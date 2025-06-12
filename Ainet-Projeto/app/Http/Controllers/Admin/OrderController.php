<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Mail\OrderCompletedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Mostra uma lista de encomendas pendentes.
     */
    public function index()
    {
        $pendingOrders = Order::where('status', 'pending')
                              ->with('member')
                              ->latest()
                              ->paginate(15);

        return view('admin.orders.index', ['orders' => $pendingOrders]);
    }

    /**
     * Mostra os detalhes de uma encomenda específica.
     */
    public function show(Order $order)
    {
        // Carrega as relações para aceder aos dados na vista de forma eficiente
        $order->load('member', 'items_orders.product');

        return view('admin.orders.show', ['order' => $order]);
    }

    /**
     * Atualiza o estado de uma encomenda para 'completed' ou 'canceled'.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:completed,canceled',
        ]);

        $newStatus = $request->input('status');

        // --- LÓGICA PARA CONCLUIR UMA ENCOMENDA ---
        if ($newStatus === 'completed') {
            // 1. VERIFICAR STOCK
            foreach ($order->items_orders as $item) {
                if ($item->quantity > $item->product->stock) {
                    return redirect()->back()->with('error', 'Não é possível concluir. Stock insuficiente para o produto: ' . $item->product->name);
                }
            }

            // 2. ATUALIZAR STOCK
            foreach ($order->items_orders as $item) {
                $item->product->decrement('stock', $item->quantity);
            }

            // 3. GERAR E GUARDAR PDF
            $pdf = Pdf::loadView('receipts.template', ['order' => $order->load('member', 'items_orders.product')]);
            $filename = 'receipts/order_' . $order->id . '_' . time() . '.pdf';
            Storage::put('public/' . $filename, $pdf->output());

            // 4. ATUALIZAR A ENCOMENDA
            $order->status = 'completed';
            $order->pdf_receipt = $filename;
            $order->save();

            // 5. ENVIAR EMAIL DE NOTIFICAÇÃO
            try {
                Mail::to($order->member->email)->send(new OrderCompletedMail($order));
            } catch (\Exception $e) {
                Log::error("Falha ao enviar email da encomenda #{$order->id}: " . $e->getMessage());
            }

            return redirect()->route('admin.orders.show', $order)->with('success', 'Encomenda marcada como concluída com sucesso!');
        }

        // --- LÓGICA PARA CANCELAR UMA ENCOMENDA ---
        if ($newStatus === 'canceled' && Auth::user()->type === 'board') {
            // 1. REEMBOLSAR VALOR AO CARTÃO VIRTUAL DO MEMBRO
            $memberCard = $order->member->card;
            if ($memberCard) {
                $memberCard->balance += $order->total;
                $memberCard->save();
            }

            // 2. ATUALIZAR A ENCOMENDA
            $order->status = 'canceled';
            $order->cancel_reason = $request->input('cancel_reason', 'Cancelado pelo administrador.');
            $order->save();

            return redirect()->route('admin.orders.show', $order)->with('success', 'Encomenda cancelada com sucesso!');
        }

        return redirect()->back()->with('error', 'Ação não permitida.');
    }
}
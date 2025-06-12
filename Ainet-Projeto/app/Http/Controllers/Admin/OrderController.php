<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\OrderCompletedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Mostra uma lista de todas as encomendas para o administrador.
     */
    public function index()
    {
        // Lógica para buscar todas as encomendas
        $orders = Order::latest()->paginate(10); // Exemplo

        return view('admin.orders.index', compact('orders'));
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
        // Lógica para mostrar uma encomenda
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Atualiza o estado de uma encomenda.
        $order->load('member', 'items_orders.product');

        return view('admin.orders.show', ['order' => $order]);
    }

    /**
     * Atualiza o estado de uma encomenda para 'completed' ou 'canceled'.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string', // Adicione as regras de validação necessárias
        ]);

        // Lógica para atualizar o estado
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Estado da encomenda atualizado com sucesso!');
    }
}
            'status' => 'required|in:completed,canceled',
        ]);

        $newStatus = $request->input('status');

        // concluir encomenda
        if ($newStatus === 'completed') {
            // verificar stock
            foreach ($order->items_orders as $item) {
                if ($item->quantity > $item->product->stock) {
                    return redirect()->back()->with('error', 'Não é possível concluir. Stock insuficiente para o produto: ' . $item->product->name);
                }
            }

            // atualizar stock
            foreach ($order->items_orders as $item) {
                $item->product->decrement('stock', $item->quantity);
            }

            // gerar PDF da fatura
            $pdf = Pdf::loadView('receipts.template', ['order' => $order->load('member', 'items_orders.product')]);
            $filename = 'receipts/order_' . $order->id . '_' . time() . '.pdf';
            Storage::put('public/' . $filename, $pdf->output());

            // atualizar encomenda
            $order->status = 'completed';
            $order->pdf_receipt = $filename;
            $order->save();

            // notificar o email
            try {
                Mail::to($order->member->email)->send(new OrderCompletedMail($order));
            } catch (\Exception $e) {
                Log::error("Falha ao enviar email da encomenda #{$order->id}: " . $e->getMessage());
            }

            return redirect()->route('admin.orders.show', $order)->with('success', 'Encomenda marcada como concluída com sucesso!');
        }

        // cancelar encomenda
        if ($newStatus === 'canceled' && Auth::user()->type === 'board') {
            // reembolsar valor ao cartão virtual
            $memberCard = $order->member->card;
            if ($memberCard) {
                $memberCard->balance += $order->total;
                $memberCard->save();
            }

            // atualizar encomenda
            $order->status = 'canceled';
            $order->cancel_reason = $request->input('cancel_reason', 'Cancelado pelo administrador.');
            $order->save();

            return redirect()->route('admin.orders.show', $order)->with('success', 'Encomenda cancelada com sucesso!');
        }

        return redirect()->back()->with('error', 'Ação não permitida.');
    }
}


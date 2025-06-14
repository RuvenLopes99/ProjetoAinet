<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Operation;
use App\Mail\OrderCompletedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Mostra uma lista de encomendas com filtros.
     */
    public function index(Request $request)
    {
        $query = Order::with('member')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Mostra os detalhes de uma encomenda específica.
     */
    public function show(Order $order)
    {
        $order->load('member', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Marca uma encomenda como 'completed'.
     */
    public function complete(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Apenas encomendas pendentes podem ser concluídas.');
        }

        foreach ($order->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->back()->with('error', 'Não é possível concluir. Stock insuficiente para o produto: ' . $item->product->name);
            }
        }

        try {
            DB::transaction(function () use ($order) {
                // Atualizar estado da encomenda
                $order->status = 'completed';
                $order->save();

                // Abater stock
                foreach ($order->items as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }

                // Gerar e guardar PDF
                $pdf = Pdf::loadView('orders.receipt', ['order' => $order]);
                $filename = 'receipts/order_' . $order->id . '.pdf';
                Storage::disk('public')->put($filename, $pdf->output());
                $order->pdf_receipt = $filename;
                $order->save();

                // Enviar email de notificação
                try {
                    // Mail::to($order->member->email)->send(new OrderCompletedMail($order));
                } catch (\Exception $e) {
                    Log::error("Falha ao enviar email da encomenda #{$order->id}: " . $e->getMessage());
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Ocorreu um erro ao concluir a encomenda: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Encomenda marcada como concluída com sucesso!');
    }

    /**
     * Marca uma encomenda como 'canceled'.
     */
    public function cancel(Request $request, Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Apenas encomendas pendentes podem ser canceladas.');
        }

        $request->validate(['cancel_reason' => 'required|string|max:255']);

        try {
            DB::transaction(function () use ($order, $request) {
                // Reembolsar valor ao cartão do membro
                $card = $order->member->card;
                if ($card) {
                    $card->balance += $order->total;
                    $card->save();

                    // Registar operação de crédito (reembolso)
                    Operation::create([
                        'card_id' => $card->id,
                        'order_id' => $order->id,
                        'type' => 'credit',
                        'credit_type' => 'order_cancellation',
                        'value' => $order->total,
                        'date' => now(),
                    ]);
                }

                // Atualizar encomenda
                $order->status = 'canceled';
                $order->cancel_reason = $request->input('cancel_reason');
                $order->save();
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Ocorreu um erro ao cancelar a encomenda: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Encomenda cancelada com sucesso!');
    }
}
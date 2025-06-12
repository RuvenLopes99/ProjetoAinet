<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

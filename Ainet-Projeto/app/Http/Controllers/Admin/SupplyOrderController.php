<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SupplyOrderController extends Controller
{
    /**
     * Mostra o formulário para criar uma nova encomenda de fornecimento,
     * listando os produtos que precisam de ser reabastecidos.
     */
    public function create()
    {
        // Busca produtos com stock baixo ou esgotado para sugerir na encomenda
        $productsToRestock = Product::whereColumn('stock', '<=', 'stock_lower_limit')
                                    ->orWhere('stock', '=', 0)
                                    ->get();

        return view('admin.supply-orders.create', ['products' => $productsToRestock]);
    }

    /**
     * Guarda as novas encomendas de fornecimento na base de dados.
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário
        $request->validate([
            'products' => 'required|array',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        $productsData = $request->input('products');
        $createdCount = 0;

        foreach ($productsData as $productId => $details) {
            // Cria uma nova encomenda de fornecimento para cada produto selecionado
            SupplyOrder::create([
                'product_id' => $productId,
                'quantity' => $details['quantity'],
                'status' => 'requested', // O estado inicial é 'requested'
                'registered_by_user_id' => Auth::id(),
            ]);
            $createdCount++;
        }

        if ($createdCount > 0) {
            return redirect()->route('admin.inventory.index')->with('success', "$createdCount encomendas de fornecimento criadas com sucesso!");
        }

        return redirect()->back()->with('error', 'Nenhum produto foi selecionado para encomenda.');
    }
    
    /**
     * Lista todas as encomendas de fornecimento.
     */
    public function index()
    {
        $supplyOrders = SupplyOrder::with('product', 'registered_by')
                                   ->latest()
                                   ->paginate(15);

        return view('admin.supply-orders.index', ['supplyOrders' => $supplyOrders]);
    }

    /**
     * Atualiza o estado de uma encomenda de fornecimento para 'completed'.
     */
    public function update(SupplyOrder $supply_order)
    {
        // Apenas pode completar encomendas que estão 'requested'
        if ($supply_order->status === 'requested') {
            // 1. Aumenta o stock do produto associado
            $supply_order->product->increment('stock', $supply_order->quantity);

            // 2. Atualiza o estado da encomenda de fornecimento
            $supply_order->status = 'completed';
            $supply_order->save();

            return redirect()->back()->with('success', 'Encomenda de fornecimento marcada como concluída e stock atualizado!');
        }

        return redirect()->back()->with('error', 'Esta encomenda já foi processada.');
    }

    /**
     * Apaga uma encomenda de fornecimento.
     */
    public function destroy(SupplyOrder $supply_order)
    {
        // Por segurança, talvez só queira permitir apagar encomendas 'requested'
        if ($supply_order->status === 'requested') {
            $supply_order->delete();
            return redirect()->back()->with('success', 'Encomenda de fornecimento apagada com sucesso.');
        }

        return redirect()->back()->with('error', 'Não é possível apagar uma encomenda já concluída.');
    }
}
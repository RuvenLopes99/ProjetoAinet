<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InventoryController extends Controller
{
    /**
     * Mostra a página de gestão de inventário com filtros.
     */
    public function index(Request $request)
    {
        // Começa a query para obter os produtos
        $query = Product::query();

        // Aplica o filtro se ele for enviado no pedido
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'low_stock':
                    // Filtra produtos onde o stock é menor ou igual ao limite inferior
                    $query->whereColumn('stock', '<=', 'stock_lower_limit');
                    break;
                case 'out_of_stock':
                    // Filtra produtos com stock zero
                    $query->where('stock', '=', 0);
                    break;
            }
        }

        // Obtém os produtos com paginação
        $products = $query->latest()->paginate(20);

        // Envia os produtos para a vista
        return view('admin.inventory.index', [
            'products' => $products,
            'currentFilter' => $request->filter // Para manter o filtro selecionado na view
        ]);
    }
    /**
     * Mostra o formulário para ajustar manualmente o stock de um produto.
     */
    public function showAdjustmentForm(Product $product)
    {
        return view('admin.inventory.adjust', ['product' => $product]);
    }

    /**
     * Guarda o ajuste de stock e regista a alteração.
     */
    public function storeAdjustment(Request $request, Product $product)
    {
        $request->validate([
            'new_stock' => 'required|integer|min:0',
        ]);

        $newStock = (int) $request->input('new_stock');
        $oldStock = $product->stock;
        
        // Calcula a diferença para registar no log
        $quantityChanged = $newStock - $oldStock;

        // Se não houver alteração, não faz nada
        if ($quantityChanged == 0) {
            return redirect()->route('admin.inventory.index')->with('info', 'Nenhuma alteração de stock foi feita.');
        }

        // 1. Regista o ajuste na tabela de logs
        StockAdjustment::create([
            'product_id' => $product->id,
            'registered_by_user_id' => Auth::id(),
            'quantity_changed' => $quantityChanged,
        ]);

        // 2. Atualiza o stock do produto para o novo valor
        $product->stock = $newStock;
        $product->save();

        return redirect()->route('admin.inventory.index')->with('success', "Stock do produto '{$product->name}' atualizado com sucesso!");
    }
}
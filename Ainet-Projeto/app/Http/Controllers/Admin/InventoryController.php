<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Mostra a página de gestão de inventário com filtros.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with('category');

        if ($request->filter === 'low_stock') {
            $query->whereColumn('stock', '<=', 'stock_lower_limit')->where('stock', '>', 0);
        } elseif ($request->filter === 'out_of_stock') {
            $query->where('stock', '=', 0);
        }

        $products = $query->orderBy('name')->paginate(25)->withQueryString();

        return view('admin.inventory.index', compact('products'));
    }

    /**
     * Guarda o ajuste de stock e regista a alteração.
     */
    public function adjustStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'new_stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);
        $oldStock = $product->stock;
        $newStock = (int) $request->new_stock;

        if ($oldStock == $newStock) {
            return back();
        }

        DB::transaction(function () use ($product, $oldStock, $newStock) {
            // 1. Cria o registo do ajuste
            StockAdjustment::create([
                'product_id' => $product->id,
                'registered_by_user_id' => Auth::id(),
                'quantity_changed' => $newStock - $oldStock,
                'created_at' => now(), // Adicionado para consistência de dados
                'updated_at' => now(), // Adicionado para consistência de dados
            ]);

            // 2. Atualiza o stock do produto
            $product->stock = $newStock;
            $product->save();
        });

        return back()->with('success', "Stock do produto '{$product->name}' ajustado com sucesso.");
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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
}
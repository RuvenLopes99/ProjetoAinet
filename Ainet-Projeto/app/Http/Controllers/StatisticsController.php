<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class StatisticsController extends Controller
{
    /**
     * Mostra o painel de estatísticas para os Administradores (Direção).
     * Corresponde à rota: admin.statistics.index
     */
    public function index()
    {
        // Estatísticas Globais para a Direção

        // Receita total de encomendas completas
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        // Número total de membros ativos (não pendentes)
        $totalMembers = User::whereIn('type', ['member', 'board'])->count();

        // Vendas por categoria
        $salesByCategory = DB::table('items_orders')
            ->join('products', 'items_orders.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'items_orders.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select('categories.name as category_name', DB::raw('SUM(items_orders.subtotal) as total_sales'))
            ->groupBy('categories.name')
            ->orderBy('total_sales', 'desc')
            ->get();

        // Top 5 produtos mais vendidos (em quantidade)
        $topSellingProducts = DB::table('items_orders')
            ->join('products', 'items_orders.product_id', '=', 'products.id')
            ->join('orders', 'items_orders.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select('products.name as product_name', DB::raw('SUM(items_orders.quantity) as total_quantity'))
            ->groupBy('products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        return view('admin.statistics.index', compact(
        'totalRevenue',
        'totalMembers',
        'salesByCategory',
        'topSellingProducts'
        ));
    }

    /**
     * Mostra o painel de estatísticas para o Membro autenticado.
     * Corresponde à rota: member.statistics.index
     */
    public function memberIndex()
    {
        $member = Auth::user();

        // Estatísticas Pessoais para o Membro

        // Total gasto pelo membro em encomendas completas
        $totalSpent = $member->orders()->where('status', 'completed')->sum('total');

        // Número total de encomendas feitas pelo membro
        $orderCount = $member->orders()->count();

        // Últimas 5 operações no cartão
        $operations = DB::table('operations')
                        ->where('card_id', $member->id) // No seu projeto, card_id = user_id
                        ->latest('date')
                        ->limit(5)
                        ->get();

        // Gastos por categoria para este membro
        $spendingByCategory = DB::table('items_orders')
            ->join('orders', 'items_orders.order_id', '=', 'orders.id')
            ->join('products', 'items_orders.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.member_id', $member->id)
            ->where('orders.status', 'completed')
            ->select('categories.name as category_name', DB::raw('SUM(items_orders.subtotal) as total_spent'))
            ->groupBy('categories.name')
            ->orderBy('total_spent', 'desc')
            ->get();

        return view('member.index', compact(
            'totalSpent',
            'orderCount',
            'operations',
            'spendingByCategory'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Mostra a página de estatísticas para os administradores.
     */
    public function index()
    {
        // Exemplo de estatísticas que pode recolher
        $totalMembers = User::where('type', 'member')->count();
        $totalBoardMembers = User::where('type', 'board')->count();
        $totalSalesValue = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::where('status', 'completed')->count();

        // Passa as variáveis para a vista
        return view('admin.statistics.index', compact(
            'totalMembers',
            'totalBoardMembers',
            'totalSalesValue',
            'totalOrders'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\OrderFormRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource for an admin.
     * (Este método provavelmente não será usado por membros, mas mantemo-lo)
     */
    public function index(Request $request)
    {
        $query = Order::query();
        // ... (A sua lógica de filtro continua aqui) ...
        $orders = $query->latest()->paginate(20);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     * Deverá mostrar a página de checkout.
     */
    public function create()
    {
        // Esta função deve mostrar a página de checkout, que terá um formulário
        // que submete os dados para o método store().
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderFormRequest $request)
    {
        $validatedData = $request->validated();
        $newOrder = Order::create($validatedData);

        // CORRIGIDO: Redireciona para a lista de encomendas do utilizador com uma mensagem.
        return redirect()->route('orders.showcase')
            ->with('success', "Encomenda #{$newOrder->id} criada com sucesso!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Garante que o utilizador só pode ver as suas próprias encomendas
        if (Auth::id() !== $order->member_id && Auth::user()->type !== 'board') {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderFormRequest $request, Order $order)
    {
        $order->update($request->validated());

        // CORRIGIDO: Redireciona para a lista de encomendas do utilizador.
        return redirect()->route('orders.showcase')
            ->with('success', "Encomenda #{$order->id} atualizada com sucesso!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        // CORRIGIDO: Redireciona para a lista de encomendas do utilizador.
        return redirect()->route('orders.showcase')
            ->with('success', 'Encomenda apagada com sucesso!');
    }

    /**
     * MÉTODO ADICIONADO PARA CORRIGIR O ERRO
     * Mostra a "montra" de encomendas do membro logado.
     */
    public function showCase(Request $request)
    {
        // Simplesmente chama o método que já tem a lógica correta.
        return $this->myOrders($request);
    }

    /**
     * Obtém e mostra as encomendas do utilizador autenticado.
     */
    public function myOrders(Request $request)
    {
        $user = $request->user();
        // Obtém as encomendas do utilizador, ordenadas pela mais recente
        $orders = $user?->orders()->latest()->paginate(20);

        // O compact('orders') já funciona mesmo que a coleção esteja vazia.
        return view('orders.myOrders', compact('orders'));
    }
}
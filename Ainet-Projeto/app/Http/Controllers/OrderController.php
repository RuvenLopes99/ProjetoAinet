<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $memberId = $request->input('member_id');
        $status = $request->input('status');
        $nif = $request->input('nif');

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $allowedSorts = [
            'id', 'member_id', 'status', 'date', 'total_items', 'shipping_cost', 'total', 'nif', 'delivery_address'
        ];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query = Order::query();

        if ($memberId) {
            $query->where('member_id', $memberId);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($nif) {
            $query->where('nif', $nif);
        }

        $query->orderBy($sort, $direction);

        $orders = $query->paginate(20);

        return view('orders.index', [
            'orders' => $orders,
            'memberId' => $memberId,
            'status' => $status,
            'nif' => $nif,
        ]);
    }

    public function showCase(Request $request)
    {
        $query = Order::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderByDesc('date')->paginate(12);

        return view('orders.showcase', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new order
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderFormRequest $request)
    {
        $newOrder = Order::create($request->validated());
        $url = route('categories.show', ['category' => $newOrder]);
        $htmlMessage = "Category <a href='$url'><strong>{$newOrder->id}</strong>
                    - </a> New Order has been created successfully!";
        return redirect()->route('categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Return the view for showing a specific order
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Return the view for editing a specific order
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderFormRequest $request, Order $order)
    {
        // Validate and update the order
        $order->update($request->validated());

        // Redirect back to the orders index with a success message
        return redirect()->route('orders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Delete the order
        $order->delete();

        // Redirect back to the orders index with a success message
        return redirect()->route('orders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Order deleted successfully!');
    }
}

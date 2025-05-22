<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all orders with pagination
        $orders = Order::paginate(20);

        // Return the view with the orders
        return view('orders.index', compact('orders'));
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
    public function store(Request $request)
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
    public function update(Request $request, Order $order)
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

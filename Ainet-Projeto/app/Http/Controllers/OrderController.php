<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\OrderFormRequest;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        $order = [
            'member_id' => $request->user()->id,
            'items' => json_encode($cart),
            'status' => 'pending',
            'date' => now(),
            'total_items' => array_sum(array_column($cart, 'quantity')), // Assuming each item has a 'quantity' field
            'shipping_cost' => 0, // Set shipping cost as needed
            'total' => array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity']; // Assuming each item has 'price' and 'quantity'
            }, $cart)),
            'nif' => $request->nif,
            'delivery_address' => $request->delivery_address,
            'pdf_receipt' => null,
            'cancel_reason' => null
        ];

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully!');
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

    public function myOrders(Request $request)
    {
        $user = $request->user();
        $orders = $user?->orders()?->paginate(20);
        if (empty($orders)) {
            return view('orders.myOrders')->with('orders', new Collection);
        }

        return view('orders.myOrders', compact('orders'));
    }
}

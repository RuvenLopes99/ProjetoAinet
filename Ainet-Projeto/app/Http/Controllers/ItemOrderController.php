<?php

namespace App\Http\Controllers;

use App\Models\ItemOrder;
use Illuminate\Http\Request;

class ItemOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all item orders with pagination
        $itemOrders = ItemOrder::paginate(20);

        // Return the view with the item orders
        return view('item_orders.index', compact('itemOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new item order
        return view('item_orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newItemOrder = ItemOrder::create($request->validated());
        $url = route('item_orders.show', ['item_order' => $newItemOrder]);
        $htmlMessage = "Item Order <a href='$url'><strong>{$newItemOrder->id}</strong>
                    - </a> New Order has been created successfully!";
        return redirect()->route('item_orders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemOrder $item_order)
    {
        // Return the view for showing a specific item order
        return view('item_orders.show', compact('item_order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemOrder $item_order)
    {
        // Return the view for editing a specific item order
        return view('item_orders.edit', compact('item_order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemOrder $item_order)
    {
        $item_order->update($request->validated());
        $url = route('item_orders.show', ['item_order' => $item_order]);
        $htmlMessage = "Item Order <a href='$url'><strong>{$item_order->id}</strong> -
                    </a>New item Order has been updated successfully!";
        return redirect()->route('item_orders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemOrder $item_order)
    {
        try {
            $url = route('item_orders.show', ['item_order' => $item_order]);
            $item_order->delete();
            $alertType = 'success';
            $alertMsg = "Item Order {$item_order->id} has been deleted successfully!";
        } catch (\Exception $e) {
            $alertType = 'error';
            $alertMsg = "Error deleting Item Order {$item_order->id}: " . $e->getMessage();
        }

        return redirect()->route('item_orders.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}

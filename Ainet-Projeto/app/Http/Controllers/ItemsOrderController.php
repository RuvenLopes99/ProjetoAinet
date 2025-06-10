<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemsOrderFormRequest;
use App\Models\ItemsOrder;
use Illuminate\Http\Request;

class ItemsOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all item orders with pagination
        $itemsOrders = ItemsOrder::paginate(20);

        // Return the view with the item orders
        return view('itemsOrders.index', compact('itemsOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new item order
        return view('itemsOrders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemsOrderFormRequest $request)
    {
        $newItemsOrder = ItemsOrder::create($request->validated());
        $url = route('itemsOrders.show', ['itemsOrder' => $newItemsOrder]);
        $htmlMessage = "Item Order <a href='$url'><strong>{$newItemsOrder->id}</strong>
                    - </a> New Order has been created successfully!";
        return redirect()->route('itemsOrders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemsOrder $itemsOrder)
    {
        // Return the view for showing a specific item order
        return view('itemsOrders.show', compact('itemsOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemsOrder $itemsOrder)
    {
        // Return the view for editing a specific item order
        return view('itemsOrders.edit', compact('itemsOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemsOrderFormRequest $request, ItemsOrder $itemsOrder)
    {
        $itemsOrder->update($request->validated());
        $url = route('itemsOrders.show', ['itemsOrder' => $itemsOrder]);
        $htmlMessage = "Item Order <a href='$url'><strong>{$itemsOrder->id}</strong> -
                    </a>New item Order has been updated successfully!";
        return redirect()->route('itemsOrders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemsOrder $itemsOrder)
    {
        try {
            $url = route('itemsOrders.show', ['itemsOrder' => $itemsOrder]);
            $itemsOrder->delete();
            $alertType = 'success';
            $alertMsg = "Item Order {$itemsOrder->id} has been deleted successfully!";
        } catch (\Exception $e) {
            $alertType = 'error';
            $alertMsg = "Error deleting Item Order {$itemsOrder->id}: " . $e->getMessage();
        }

        return redirect()->route('itemsOrders.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}

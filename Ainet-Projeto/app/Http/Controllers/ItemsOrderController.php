<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ItemsOrder;
use Illuminate\Http\Request;
use App\Http\Requests\ItemsOrderFormRequest;

class ItemsOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderId = $request->input('order_id');
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $subtotal = $request->input('subtotal');

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $allowedSorts = [
            'id', 'order_id', 'product_id', 'quantity', 'subtotal'
        ];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query = \App\Models\ItemsOrder::query();

        if ($orderId) {
            $query->where('order_id', $orderId);
        }
        if ($productId) {
            $query->where('product_id', $productId);
        }
        if ($quantity) {
            $query->where('quantity', $quantity);
        }
        if ($subtotal) {
            $query->where('subtotal', $subtotal);
        }

        $query->orderBy($sort, $direction);

        $itemsOrders = $query->paginate(20);

        return view('itemsOrders.index', [
            'itemsOrders' => $itemsOrders,
            'orderId' => $orderId,
            'productId' => $productId,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ]);
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
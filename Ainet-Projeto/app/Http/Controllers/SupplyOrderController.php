<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;

class SupplyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        // Fetch all supply orders with pagination
        $supplyOrders = SupplyOrder::paginate(20);

        // Return the view with the supply orders
        return view('supplyOrders.index', compact('supplyOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new supply order
        return view('supplyOrders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and create a new supply order
        $newSupplyOrder = SupplyOrder::create($request->validated());

        // Redirect to the supply orders index with a success message
        $url = route('supplyOrders.show', ['supplyOrders' => $newSupplyOrder]);
        $htmlMessage = "Supply Order <a href='$url'><strong>{$newSupplyOrder->id}</strong>
                    - </a> New Supply Order has been created successfully!";
        return redirect()->route('supplyOrders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplyOrder $supplyOrders)
    {
        // Return the view for showing a specific supply order
        return view('supplyOrders.show', compact('supplyOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplyOrder $supplyOrders)
    {
        // Return the view for editing a specific supply order
        return view('supplyOrders.edit', compact('supplyOrders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupplyOrder $supplyOrders)
    {
        // Validate and update the supply order
        $supplyOrders->update($request->validated());

        // Redirect back to the supply orders index with a success message
        $url = route('supply_orders.show', ['supply_order' => $supplyOrders]);
        $htmlMessage = "Supply Order <a href='$url'><strong>{$supplyOrders->id}</strong>
                    - </a> Supply Order has been updated successfully!";
        return redirect()->route('supplyOrders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplyOrder $supplyOrders)
    {
        // Delete the supply order
        $supplyOrders->delete();

        // Redirect back to the supply orders index with a success message
        return redirect()->route('supplyOrders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Supply Order deleted successfully!');
    }
}

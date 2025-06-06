<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplyOrderFormRequest;
use Illuminate\View\View;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;

class SupplyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $supplyOrders = SupplyOrder::paginate(20);

        $filterByQuantity = $request->input('quantity');
        $filterByStatus = $request->input('status');
        $filterByUser = $request->input('registered_by_user_id');
        $filterByProductId = $request->input('product_id');

        if( $filterByQuantity || $filterByStatus || $filterByUser || $filterByProductId ) {
            $supplyOrders = SupplyOrder::query();

            if ($filterByQuantity) {
                $supplyOrders->where('quantity', '>=', $filterByQuantity);
            }

            if ($filterByStatus) {
                $supplyOrders->where('status', $filterByStatus);
            }

            if ($filterByUser) {
                $supplyOrders->where('registered_by_user_id', $filterByUser);
            }

            if ($filterByProductId) {
                $supplyOrders->where('product_id', $filterByProductId);
            }

            $supplyOrders = $supplyOrders->paginate(20);
        }

        return view('supplyOrders.index', compact('supplyOrders', 'filterByStatus', 'filterByUser', 'filterByQuantity', 'filterByProductId'));
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
    public function store(SupplyOrderFormRequest $request)
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
    public function show(SupplyOrder $supplyOrder)
    {
        // Return the view for showing a specific supply order
        return view('supplyOrders.show', compact('supplyOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplyOrder $supplyOrder)
    {
        // Return the view for editing a specific supply order
        return view('supplyOrders.edit', compact('supplyOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplyOrderFormRequest $request, SupplyOrder $supplyOrder)
    {
        // Validate and update the supply order
        $supplyOrder->update($request->validated());

        // Redirect back to the supply orders index with a success message
        $url = route('supplyOrders.show', ['supplyOrder' => $supplyOrder]);
        $htmlMessage = "Supply Order <a href='$url'><strong>{$supplyOrder->id}</strong>
                    - </a> Supply Order has been updated successfully!";
        return redirect()->route('supplyOrders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplyOrder $supplyOrder)
    {
        // Delete the supply order
        $supplyOrder->delete();

        // Redirect back to the supply orders index with a success message
        return redirect()->route('supplyOrders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Supply Order deleted successfully!');
    }
}

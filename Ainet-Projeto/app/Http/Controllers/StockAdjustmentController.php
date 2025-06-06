<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockAdjustmentFormRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class StockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        // Fetch all stock adjustments with pagination
        $stockAdjustments = StockAdjustment::paginate(20);

        $filterByQuantityChanged = $request->input('quantity_changed');
        $filterByUser = $request->input('registered_by_user_id');
        $filterByProductId = $request->input('product_id');

        if( $filterByQuantityChanged || $filterByUser || $filterByProductId ) {
            $stockAdjustments = stockAdjustment::query();

            if ($filterByQuantityChanged) {
                $stockAdjustments->where('quantity_changed', '>=', $filterByQuantityChanged);
            }

            if ($filterByUser) {
                $stockAdjustments->where('registered_by_user_id', $filterByUser);
            }

            if ($filterByProductId) {
                $stockAdjustments->where('product_id', $filterByProductId);
            }

            $supplyOrders = $stockAdjustments->paginate(20);
        }

        // Return the view with the stock adjustments
        return view('stockAdjustments.index', compact('stockAdjustments', 'filterByQuantityChanged', 'filterByUser', 'filterByProductId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $stockAdjustment = new StockAdjustment();

        // Return the view for creating a new stock adjustment
        return view('stockAdjustments.create', compact('stockAdjustment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockAdjustmentFormRequest $request) : RedirectResponse
    {
        // Validate and create a new stock adjustment
        $newStockAdjustment = StockAdjustment::create($request->validated());

        // Redirect to the stock adjustments index with a success message
        $url = route('stockAdjustments.show', ['stockAdjustments' => $newStockAdjustment]);
        $htmlMessage = "Stock Adjustment <a href='$url'><strong>{$newStockAdjustment->id}</strong>
                    - </a> New Stock Adjustment has been created successfully!";
        return redirect()->route('stockAdjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(StockAdjustment $stockAdjustment)
    {
        // Return the view for showing a specific stock adjustment
        return view('stockAdjustments.show', compact('stockAdjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAdjustment $stockAdjustment)
    {
        // Return the view for editing a specific stock adjustment
        return view('stockAdjustments.edit', compact('stockAdjustment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockAdjustmentFormRequest $request, StockAdjustment $stockAdjustment)
    {
        // Validate and update the stock adjustment
        $stockAdjustment->update($request->validated());

        // Redirect back to the stock adjustments index with a success message
        $url = route('stockAdjustments.show', ['stockAdjustments' => $stockAdjustment]);
        $htmlMessage = "Stock Adjustment <a href='$url'><strong>{$stockAdjustment->id}</strong>
                    - </a> has been updated successfully!";
        return redirect()->route('stockAdjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAdjustment $stockAdjustment)
    {
        // Delete the stock adjustment
        $stockAdjustment->delete();

        // Redirect back to the stock adjustments index with a success message
        return redirect()->route('stockAdjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Stock Adjustment deleted successfully!');
    }
}

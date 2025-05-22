<?php

namespace App\Http\Controllers;

use App\Models\StockAdjustment;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all stock adjustments with pagination
        $stockAdjustments = StockAdjustment::paginate(20);

        // Return the view with the stock adjustments
        return view('stock_adjustments.index', compact('stockAdjustments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new stock adjustment
        return view('stock_adjustments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and create a new stock adjustment
        $newStockAdjustment = StockAdjustment::create($request->validated());

        // Redirect to the stock adjustments index with a success message
        $url = route('stock_adjustments.show', ['stock_adjustment' => $newStockAdjustment]);
        $htmlMessage = "Stock Adjustment <a href='$url'><strong>{$newStockAdjustment->id}</strong>
                    - </a> New Stock Adjustment has been created successfully!";
        return redirect()->route('stock_adjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(StockAdjustment $stock_adjustment)
    {
        // Return the view for showing a specific stock adjustment
        return view('stock_adjustments.show', compact('stock_adjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAdjustment $stock_adjustment)
    {
        // Return the view for editing a specific stock adjustment
        return view('stock_adjustments.edit', compact('stock_adjustment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockAdjustment $stock_adjustment)
    {
        // Validate and update the stock adjustment
        $stock_adjustment->update($request->validated());

        // Redirect back to the stock adjustments index with a success message
        $url = route('stock_adjustments.show', ['stock_adjustment' => $stock_adjustment]);
        $htmlMessage = "Stock Adjustment <a href='$url'><strong>{$stock_adjustment->id}</strong>
                    - </a> has been updated successfully!";
        return redirect()->route('stock_adjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAdjustment $stock_adjustment)
    {
        // Delete the stock adjustment
        $stock_adjustment->delete();

        // Redirect back to the stock adjustments index with a success message
        return redirect()->route('stock_adjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Stock Adjustment deleted successfully!');
    }
}

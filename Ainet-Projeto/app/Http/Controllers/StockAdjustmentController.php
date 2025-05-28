<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        // Fetch all stock adjustments with pagination
        $stockAdjustments = StockAdjustment::paginate(20);

        // Return the view with the stock adjustments
        return view('stockAdjustments.index', compact('stockAdjustments'));
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
    public function store(Request $request) : RedirectResponse
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
    public function show(StockAdjustment $stockAdjustments)
    {
        // Return the view for showing a specific stock adjustment
        return view('stockAdjustments.show', compact('stockAdjustments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAdjustment $stockAdjustments)
    {
        // Return the view for editing a specific stock adjustment
        return view('stockAdjustments.edit', compact('stockAdjustments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockAdjustment $stockAdjustments)
    {
        // Validate and update the stock adjustment
        $stockAdjustments->update($request->validated());

        // Redirect back to the stock adjustments index with a success message
        $url = route('stockAdjustments.show', ['stockAdjustments' => $stockAdjustments]);
        $htmlMessage = "Stock Adjustment <a href='$url'><strong>{$stockAdjustments->id}</strong>
                    - </a> has been updated successfully!";
        return redirect()->route('stockAdjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAdjustment $stockAdjustments)
    {
        // Delete the stock adjustment
        $stockAdjustments->delete();

        // Redirect back to the stock adjustments index with a success message
        return redirect()->route('stockAdjustments.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Stock Adjustment deleted successfully!');
    }
}

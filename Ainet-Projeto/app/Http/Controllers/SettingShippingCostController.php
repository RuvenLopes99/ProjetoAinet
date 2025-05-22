<?php

namespace App\Http\Controllers;

use App\Models\SettingShippingCost;
use Illuminate\Http\Request;

class SettingShippingCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all shipping costs with pagination
        $shippingCosts = SettingShippingCost::paginate(20);

        // Return the view with the shipping costs
        return view('settings_shipping_costs.index', compact('shippingCosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new shipping cost
        return view('settings_shipping_costs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and create a new shipping cost
        $newShippingCost = SettingShippingCost::create($request->validated());

        // Redirect to the shipping costs index with a success message
        $url = route('settings_shipping_costs.show', ['settings_shipping_cost' => $newShippingCost]);
        $htmlMessage = "Shipping Cost <a href='$url'><strong>{$newShippingCost->id}</strong>
                    - </a> New Shipping Cost has been created successfully!";
        return redirect()->route('settings_shipping_costs.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(SettingShippingCost $settings_shipping_cost)
    {
        // Return the view for showing a specific shipping cost
        return view('settings_shipping_costs.show', compact('settings_shipping_cost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SettingShippingCost $settings_shipping_cost)
    {
        // Return the view for editing a specific shipping cost
        return view('settings_shipping_costs.edit', compact('settings_shipping_cost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SettingShippingCost $settings_shipping_cost)
    {
        // Validate and update the shipping cost
        $settings_shipping_cost->update($request->validated());

        // Redirect back to the shipping costs index with a success message
        return redirect()->route('settings_shipping_costs.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shipping Cost updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SettingShippingCost $settings_shipping_cost)
    {
        // Delete the shipping cost
        $settings_shipping_cost->delete();

        // Redirect back to the shipping costs index with a success message
        return redirect()->route('settings_shipping_costs.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shipping Cost deleted successfully!');
    }
}

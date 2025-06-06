<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\SettingsShippingCost;
use App\Http\Requests\SettingsShippingCostFormRequest;

class SettingsShippingCostController extends Controller
{
    /**
     * Display the shipping cost settings.
     */
    public function index(Request $request) : View
    {
        // Fetch the shipping cost settings from the database
        $settingsShippingCosts = SettingsShippingCost::paginate(20);

        $filterByMinValue = $request->input('min_value_threshold');
        $filterByMaxValue = $request->input('max_value_threshold');
        $filterByShippingCost = $request->input('shipping_cost');

        if( $filterByMinValue || $filterByMaxValue || $filterByShippingCost ) {
            $settingsShippingCosts = SettingsShippingCost::query();

            if ($filterByMinValue) {
                $settingsShippingCosts->where('min_value_threshold', '<=', $filterByMinValue);
            }

            if ($filterByMaxValue) {
                $settingsShippingCosts->where('max_value_threshold', '>=', $filterByMaxValue);
            }

            if ($filterByShippingCost) {
                $settingsShippingCosts->where('shipping_cost', $filterByShippingCost);
            }

            $settingsShippingCosts = $settingsShippingCosts->paginate(20);
        }

        // Return the view with the shipping cost settings
        return view('settingsShippingCosts.index', compact('settingsShippingCosts', 'filterByMinValue', 'filterByMaxValue', 'filterByShippingCost'));
    }

    /**
     * Show the form for editing the shipping cost settings.
     */
    public function edit()
    {
        // Fetch the current shipping cost settings
        $shippingCostSettings = SettingsShippingCost::first();

        // Return the edit view with the current settings
        return view('settingsShippingCosts.edit', compact('shippingCostSettings'));
    }

    /**
     * Update the shipping cost settings in storage.
     */
    public function update(SettingsShippingCostFormRequest $settingsShippingCost)
    {
        // Update with validated data
        $settingsShippingCost->update($settingsShippingCost->validated());
        $url = route('settingsShippingCosts.index');
        $htmlMessage = "Shipping cost settings have been updated successfully!";
        $htmlMessage .= " <a href='$url'>View Settings</a>";

        // Redirect back with a success message
        return redirect()
            ->route('settingsShippingCosts.index')
            ->with('success', 'Shipping cost updated successfully.');
    }
}

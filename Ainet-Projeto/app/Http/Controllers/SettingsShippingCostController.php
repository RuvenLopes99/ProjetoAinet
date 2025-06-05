<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsShippingCostsFormRequest;
use App\Models\SettingsShippingCost;
use Illuminate\Http\Request;

class SettingsShippingCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all shipping costs with pagination
        $settingsShippingCosts = SettingsShippingCost::paginate(20);

        // Return the view with the shipping costs
        return view('settingsShippingCosts.index', compact('settingsShippingCosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new shipping cost
        return view('settingsShippingCosts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingsShippingCostsFormRequest $request)
    {
        // Validate and create a new shipping cost
        $newShippingCost = SettingsShippingCost::create($request->validated());

        // Redirect to the shipping costs index with a success message
        $url = route('settingsShippingCosts.show', ['settingsShippingCost' => $newShippingCost]);
        $htmlMessage = "Shipping Cost <a href='$url'><strong>{$newShippingCost->id}</strong>
                    - </a> New Shipping Cost has been created successfully!";
        return redirect()->route('settingsShippingCosts.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(SettingsShippingCost $settingsShippingCost)
    {
        // Return the view for showing a specific shipping cost
        return view('settingsShippingCosts.show', compact('settingsShippingCost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SettingsShippingCost $settingsShippingCost)
    {
        // Return the view for editing a specific shipping cost
        return view('settingsShippingCosts.edit', compact('settingsShippingCost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingsShippingCostsFormRequest $request, SettingsShippingCost $settingsShippingCost)
    {
        // Validate and update the shipping cost
        $settingsShippingCost->update($request->validated());

        // Redirect back to the shipping costs index with a success message
        return redirect()->route('settingsShippingCosts.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shipping Cost updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SettingsShippingCost $settingsShippingCost)
    {
        // Delete the shipping cost
        $settingsShippingCost->delete();

        // Redirect back to the shipping costs index with a success message
        return redirect()->route('settingsShippingCosts.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shipping Cost deleted successfully!');
    }
}

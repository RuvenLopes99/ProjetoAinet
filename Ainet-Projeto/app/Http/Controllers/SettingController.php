<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\SettingFormRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $filterByMembershipFee = $request->input('membership_fee');

        $query = Setting::query();

        if ($filterByMembershipFee !== null && $filterByMembershipFee !== '') {
            $query->where('membership_fee', $filterByMembershipFee);
        }

        $settings = $query->paginate(20);

        return view('settings.index', [
            'settings' => $settings,
            'filterByMembershipFee' => $filterByMembershipFee,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new setting
        return view('Settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingFormRequest $request)
    {
        // Validate and create a new setting
        $newSetting = Setting::create($request->validated());

        // Redirect to the settings index with a success message
        $url = route('settings.show', ['setting' => $newSetting]);
        $htmlMessage = "Setting <a href='$url'><strong>{$newSetting->id}</strong>
                    - </a> New Setting has been created successfully!";
        return redirect()->route('settings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        // Return the view for showing a specific setting
        return view('Settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        // Return the view for editing a specific setting
        return view('Settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingFormRequest $request, Setting $setting)
    {
        // Validate and update the setting
        $setting->update($request->validated());

        // Redirect back to the settings index with a success message
        return redirect()->route('settings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Setting updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        // Delete the setting
        $setting->delete();

        // Redirect back to the settings index with a success message
        return redirect()->route('settings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Setting deleted successfully!');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\View\View;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        // Fetch all operations with pagination
        $operations = Operation::paginate(20);

        // Return the view with the operations
        return view('operations.index', compact('operations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new operation
        return view('operations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Operation $operation)
    {
        // Return the view for showing a specific operation
        return view('operations.show', compact('operation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operation $operation)
    {
        // Return the view for editing a specific operation
        return view('operations.edit', compact('operation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Operation $operation)
    {
        // Validate and update the operation
        $operation->update($request->validated());

        // Redirect back to the operations index with a success message
        return redirect()->route('operations.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Operation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operation $operation)
    {
        // Delete the operation
        $operation->delete();

        // Redirect back to the operations index with a success message
        return redirect()->route('operations.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Operation deleted successfully!');
    }
}

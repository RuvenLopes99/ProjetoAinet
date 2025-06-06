<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperationFormRequest;
use App\Models\Operation;
use Illuminate\View\View;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $cardId = $request->input('card_id');
        $type = $request->input('type');
        $orderId = $request->input('order_id');

        $query = Operation::query();

        if ($cardId) {
            $query->where('card_id', $cardId);
        }
        if ($type) {
            $query->where('type', $type);
        }
        if ($orderId) {
            $query->where('order_id', $orderId);
        }

        $operations = $query->paginate(20);

        return view('operations.index', [
            'operations' => $operations,
            'cardId' => $cardId,
            'type' => $type,
            'orderId' => $orderId,
        ]);
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
    public function store(OperationFormRequest $request)
    {
        $newOperation = Operation::create($request->validated());
        $url = route('operations.show', ['operation' => $newOperation]);
        $htmlMessage = "Operation <a href='$url'><strong>{$newOperation->name}</strong>";

        return redirect()->route('operations.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Operation <strong>{$newOperation->name}</strong> created successfully!");
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
    public function update(OperationFormRequest $request, Operation $operation)
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

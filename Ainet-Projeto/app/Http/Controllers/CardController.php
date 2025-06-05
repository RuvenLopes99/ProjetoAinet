<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardFormRequest;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all cards with pagination
        $cards = Card::paginate(20);

        // Return the view with the cards
        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new card
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardFormRequest $request)
    {
        $newCard = Card::create($request->validated());
        $url = route('cards.show', ['card' => $newCard]);
        $htmlMessage = "Card <a href='$url'><strong>{$newCard->id}</strong>
                    - </a>Card has been created successfully!";
        return redirect()->route('cards.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        // Return the view for showing a specific card
        return view('cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        // Return the view for editing a specific card
        return view('cards.edit', compact('card'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CardFormRequest $request, Card $card)
    {
        // Validate and update the card
        $card->update($request->validated());

        // Redirect back to the cards index with a success message
        return redirect()->route('cards.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Card updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        // Delete the card
        $card->delete();

        // Redirect back to the cards index with a success message
        return redirect()->route('cards.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Card deleted successfully!');
    }
}

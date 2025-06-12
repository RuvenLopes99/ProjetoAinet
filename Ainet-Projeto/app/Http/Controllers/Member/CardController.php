<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    /**
     * Mostra o cartão do membro atualmente autenticado.
     */
    public function show()
    {
        // Vai buscar o utilizador autenticado
        $user = Auth::user();

        // Obtém o cartão e as suas operações (transações)
        // O 'with('operations')' é para carregar o histórico de uma só vez
        $card = $user->card()->with('operations')->firstOrFail();

        // Retorna a vista com os dados do cartão
        return view('member.card.show', compact('card'));
    }
}

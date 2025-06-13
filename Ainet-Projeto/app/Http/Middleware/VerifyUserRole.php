<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check() || !$user = Auth::user()) {
            return redirect('login');
        }

        // Usamos a mesma lógica de Enums que já confirmámos que funciona
        $userRoleValue = $user->type->value;

        // in_array() verifica se o tipo do utilizador está na lista de roles permitidas
        if (in_array($userRoleValue, $roles)) {
            return $next($request);
        }

        abort(403, 'Acesso Não Autorizado.');
    }
}
<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Extrai o valor da string do Enum do utilizador (ex: 'board')
        $userRoleValue = $user->type->value;

        foreach ($roles as $role) {
            // Agora compara duas strings (ex: 'board' == 'board')
            if ($userRoleValue == $role) {
                return $next($request);
            }
        }

        // Se o utilizador não tiver a função necessária, aborta com um 403 Forbidden
        abort(403, 'Acesso Não Autorizado.');
    }
}

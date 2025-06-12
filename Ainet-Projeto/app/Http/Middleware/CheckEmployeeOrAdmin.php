<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmployeeOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        // Permite acesso se for employee ou board
        if ($user->type === 'employee' || $user->type === 'board') {
            return $next($request);
        }

        // Se não for, nega o acesso
        abort(403, 'Acesso Não Autorizado.');
    }
}
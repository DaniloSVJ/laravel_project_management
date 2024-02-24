<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        dd($user->roles);
        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        if ($user->roles === 'manager') {
            return $next($request);
          
        }

        return response()->json(['error' => 'Acesso não autorizado'], 403);
    }

}

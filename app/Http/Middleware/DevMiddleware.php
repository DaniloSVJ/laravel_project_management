<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth; 


class DevMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // $token = $request->bearerToken();
        $user = Auth::user();
       
        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        if ($user->roles !== 'dev') {
            return response()->json(['error' => 'Acesso não autorizado'], 403);
        }

        return $next($request);

    }
}

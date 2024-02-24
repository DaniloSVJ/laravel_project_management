<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TechLeaderMiddleware
{
   
    public function handle(Request $request, Closure $next)
    {
        // $token = $request->bearerToken();
        $user = Auth::user();
       
        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        if ($user->roles === 'techleader') {
            return $next($request);
          
        }

        return response()->json(['error' => 'Acesso não autorizado'], 403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth; 


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // $token = $request->bearerToken();
        $user = Auth::user();
       
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        if ($user->roles === 'admin') {
            return $next($request);
          
        }

        return response()->json(['error' => 'Acesso não autorizado'], 403);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function reguser(Request $request)
    {
         
        $user = User::create($request->all());
      
        return response()->json([
            'message' => 'User registered successfully!'
        ], 201);
    }

   
    public function login(Request $request)
    {
       
        
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
           
        }
        $user = Auth::user();
        $token = $user->createToken('Bearer Token', ['expires_in' => 10080])->plainTextToken;
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'token' => $token
        ]);


    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        return response()->json([
            'message' => 'Logout successful!'
        ]);
    }
}

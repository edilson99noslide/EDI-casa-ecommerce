<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateWithJwtCookie
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('token');

        if (!$token)
            return response()->json([
                'success' => false,
                'message' => 'Não foi possivel autenticar com o token.'
            ], 401);

        try {
            JWTAuth::setToken($token)->authenticate();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido.'
            ]);
        }

        return $next($request);
    }
}

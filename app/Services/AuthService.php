<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService {
    /**
     * Tenta autenticar e retorna o token JWT
     *
     * @param array $credentials
     * @return string
     */
    public function authenticate(array $credentials): string {
        if(!$token = Auth::guard('api')->attempt($credentials)) {
            return 'unauthorized';
        }

        return $token;
    }

    /**
     * Formata a resposta do token JWT
     *
     * @param string $token
     * @return array
     */
    public function tokenResponse(string $token): array {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
            'user'         => Auth::guard('api')->user(),
        ];
    }

    /**
     * Responsável por criar um token temporário (1 minuto)
     *
     * @param array $credentials
     * @return string|null
     */
    public function createTemporaryToken(array $credentials): ?string {
        Auth::guard('api')->factory()->setTTL(1);
        return Auth::guard('api')->attempt($credentials);
    }

    /**
     * Responsável por setar o token no cookie
     *
     * @param string $token
     * @return JsonResponse
     */
    public function setCookie(): JsonResponse {
        $user = Auth::guard('api')->user();

        Auth::guard('api')->factory()->setTTL(60 * 24);
        $newToken = Auth::guard('api')->login($user);

        $cookie = cookie(
            name: 'token',
            value: $newToken,
            minutes: 60 * 24,
            path: '/',
            domain: null,
            secure: true,
            httpOnly: true,
            sameSite: 'Strict'
        );

        return response()->json([
            'success' => true,
            'message' => 'Login efetuado com sucesso.'
        ])->cookie($cookie);
    }
}

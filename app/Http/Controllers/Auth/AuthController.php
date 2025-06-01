<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\UseCases\Auth\ChangePasswordUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    protected AuthService $authService;

    public function __construct(AuthService $authService, ChangePasswordUseCase $changePasswordUseCase) {
        $this->authService = $authService;
        $this->changePasswordUseCase = $changePasswordUseCase;
    }

    /**
     * Responsável por autenticar um usuário
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) {
        $token = $this->authService->authenticate($request->validated());

        if($token === 'unauthorized')
            return response()->json([
                'success' => false,
                'message' => 'Login ou senha incorretos.'
            ], 401);

        $cookie = cookie(
            name: 'token',
            value: $token,
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

    /**
     * Responsável por realizar um logout do usuário autenticado
     *
     * @return JsonResponse
     */
    public function logout() {
        auth('api')->logout();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }

    /**
     * Responsável por retornar as informações do usuário autenticado
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Responsável por gerar um novo token para o usuário autenticado
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse {
        $newToken = Auth::guard('api')->refresh();

        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Responsável por alterar a senha do usuário logado
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse {
        $passwordChange = $this->changePasswordUseCase->handle($request->validated());

        if(!$passwordChange)
            return response()->json([
                'success' => false,
                'message' => 'Senha incorreta.'
            ], 422);

        return response()->json([
            'success' => true,
            'message' => 'Senha alterada com sucesso.'
        ]);
    }
}

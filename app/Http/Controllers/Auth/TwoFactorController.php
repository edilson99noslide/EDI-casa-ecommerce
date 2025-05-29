<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateTwoFactorRequest;
use App\UseCases\TwoFactor\DisableTwoFactorUseCase;
use App\UseCases\TwoFactor\EnableTwoFactorUseCase;
use App\UseCases\TwoFactor\ValidateTwoFactorUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller {
    public function __construct(
        private EnableTwoFactorUseCase $enableTwoFactorUseCase,
        private DisableTwoFactorUseCase $disableTwoFactorUseCase,
        private ValidateTwoFactorUseCase $validateTwoFactorUseCase,
    ) {}

    public function enableTwoFactor(): JsonResponse {
        $user = Auth::user();
        $data = $this->enableTwoFactorUseCase->handle($user);

        return response()->json([
            'success' => true,
            'message' => 'Autenticação de dois fatores habilitada.',
            'data'  => $data,
        ]);
    }

    public function disableTwoFactor(): JsonResponse {
        $user = Auth::user();
        $this->disableTwoFactorUseCase->handle($user);

        return response()->json([
            'success' => true,
            'message' => 'Autenticação de dois fatores desabilitada.',
        ]);
    }

    public function validateTwoFactor(ValidateTwoFactorRequest $request): JsonResponse {
        $user = Auth::user();
        if(!$user->two_factor_enabled)
            return response()->json([
                'success' => false,
                'message' => 'Usuário não possui autenticação de dois fatores.',
            ]);

        $isValid = $this->validateTwoFactorUseCase->handle($user, $request->get('2fa_code'));

        return response()->json([
           'success' => $isValid,
           'message' => $isValid ? 'Código válido.' : 'Código invalido.',
        ], $isValid ? 201 : 422);
    }
}

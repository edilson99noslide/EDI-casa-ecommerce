<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\UseCases\Auth\ResetPasswordUseCase;

class ResetPasswordController extends Controller {
    public function __construct(
        private ResetPasswordUseCase $resetPasswordUseCase,
    ) {}

    public function __invoke(ResetPasswordRequest $request) {
        $data = $request->validated();

        $sucess = $this->resetPasswordUseCase->handle($data);

        if(!$sucess)
            return response()->json([
                'success' => false,
                'message' => 'Token inválido ou expirado!'
            ], 400);

        return response()->json([
            'success' => true,
            'message' => 'Sua senha foi alterada com sucesso.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\UseCases\Auth\ForgotPasswordUseCase;

class ForgotPasswordController extends Controller {
    public function __construct(
        private ForgotPasswordUseCase $forgotPasswordUseCase,
    ) {}

    public function __invoke(ForgotPasswordRequest $request) {
        $this->forgotPasswordUseCase->handle($request->input('email'));

        return response()->json([
            'sucess' => true,
            'message' => 'Email de recuperação enviado com sucesso!'
        ]);
    }
}

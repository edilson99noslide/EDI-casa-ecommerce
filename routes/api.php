<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Register\RegisterController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateWithJwtCookie;

Route::prefix('auth')->group(function () {
    // Registro
    Route::post('/register', [RegisterController::class, 'register']);

    // Login
    Route::post('/login', [AuthController::class, 'login']);

    // Recuperação de senha
    Route::post('/forgot-password', ForgotPasswordController::class)->name('password.email');
    Route::post('/reset-password', ResetPasswordController::class)->name('password.reset');

    // Usuário logado
    Route::middleware(AuthenticateWithJwtCookie::class)->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
    });

    // 2FA
    Route::prefix('/2fa')->middleware('auth:api')->group(function () {
        Route::post('/enable', [TwoFactorController::class, 'enableTwoFactor']);
        Route::post('/disable', [TwoFactorController::class, 'disableTwoFactor']);
        Route::post('/validate', [TwoFactorController::class, 'validateTwoFactor']);
    });
});

Route::prefix('users')->middleware(AuthenticateWithJwtCookie::class)->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{userId}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{userId}', [UserController::class, 'update']);
    Route::delete('/{userId}', [UserController::class, 'destroy']);
});

// Rota de teste básica
Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'pong'
    ]);
});

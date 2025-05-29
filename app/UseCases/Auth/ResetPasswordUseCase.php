<?php

namespace App\UseCases\Auth;

use Illuminate\Support\Facades\Password;

class ResetPasswordUseCase {
    public function handle(array $data): bool {
        $status = Password::reset([
            'email'                 => $data['email'],
            'token'                 => $data['token'],
            'password'              => $data['password'],
        ],
        function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        return $status === Password::PASSWORD_RESET;
    }
}

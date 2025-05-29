<?php

namespace App\UseCases\Auth;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordUseCase {
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(array $data) {
        $user = Auth::user();

        if(!Hash::check($data['old_password'], $user->password))
            return false;

        $this->userRepository->changePassword($user, $data['new_password']);

        return true;
    }
}

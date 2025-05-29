<?php

namespace App\UseCases\Auth;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Password;

class ForgotPasswordUseCase {
    public function __construct(
      private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $email) {
        $user = $this->userRepository->findByEmail($email);

        if(!$user)
            return null;

        $status = Password::sendResetLink(['email' => $email]);

        if($status !== Password::RESET_LINK_SENT)
            return null;
    }
}

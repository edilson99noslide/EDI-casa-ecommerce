<?php

namespace App\UseCases\User;

use App\Repositories\UserRepositoryInterface;

class GetUserUseCase {
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(int $userId) {
        $user = $this->userRepository->findById($userId);

        if(!$user)
            return null;

        return $user;
    }
}

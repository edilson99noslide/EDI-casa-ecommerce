<?php

namespace App\UseCases\User;

use App\Repositories\UserRepositoryInterface;

class DeleteUserUseCase {
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(int $userId): bool {
        $user = $this->userRepository->findById($userId);

        if (!$user)
            return false;

        return $this->userRepository->delete($userId);
    }
}

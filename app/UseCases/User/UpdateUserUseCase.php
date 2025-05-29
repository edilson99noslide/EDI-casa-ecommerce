<?php

namespace App\UseCases\User;

use App\Repositories\UserRepositoryInterface;

class UpdateUserUseCase {
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(int $userId, array $data) {
        $user = $this->userRepository->findById($userId);

        if(!$user)
            return null;

        return $this->userRepository->update($user, $data);
    }
}

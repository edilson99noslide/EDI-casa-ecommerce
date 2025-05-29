<?php

namespace App\UseCases\User;

use App\Repositories\UserRepositoryInterface;

class GetAllUsersUseCase {
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle() {
        return $this->userRepository->getAll();
    }
}

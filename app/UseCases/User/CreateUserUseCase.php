<?php

namespace App\UseCases\User;

use App\Repositories\UserRepositoryInterface;

class CreateUserUseCase {
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(array $data) {
        return $this->userRepository->create($data);
    }
}

<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface {
    public function findById(int $userId): ?User;
    public function findByEmail(string $email): ?User;
    public function getAll(): Collection;
    public function update(User $user, array $data): ?User;
    public function create(array $data): ?User;
    public function delete(int $userId): ?bool;
    public function changePassword(User $user, string $password): ?User;
}

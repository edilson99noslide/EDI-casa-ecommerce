<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepositoryInterface {
    public function findById(int $userId): ?User {
        return User::find($userId);
    }

    public function findByEmail(string $email): ?User {
        return User::where('email', $email)->first();
    }

    public function getAll(): Collection {
        return User::all();
    }

    public function create(array $data): ?User {
        return User::create($data);
    }

    public function update(User $user, array $data): ?User {
        $user->fill($data);
        $user->save();

        return $user;
    }

    public function delete(int $userId): ?bool {
        return User::destroy($userId);
    }

    public function changePassword(User $user, string $password): ?User {
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }
}

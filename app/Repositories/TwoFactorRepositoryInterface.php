<?php

namespace App\Repositories;

use App\Models\User;

interface TwoFactorRepositoryInterface {
    public function enableTwoFactor(User $user, string $secret): User;
    public function disableTwoFactor(User $user): User;
    public function getSecret(User $user): string;
}

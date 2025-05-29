<?php

namespace App\Repositories;

use App\Models\User;

class EloquentTwoFactorRepository implements TwoFactorRepositoryInterface {

    public function enableTwoFactor(User $user, string $secret): User {
        $user->google2fa_secret   = $secret;
        $user->two_factor_enabled = true;
        $user->save();

        return $user;
    }

    public function disableTwoFactor(User $user): User {
        $user->google2fa_secret   = null;
        $user->two_factor_enabled = false;
        $user->save();

        return $user;
    }

    public function getSecret(User $user): string {
        return $user->google2fa_secret;
    }
}

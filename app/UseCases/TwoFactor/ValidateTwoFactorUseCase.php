<?php

namespace App\UseCases\TwoFactor;

use App\Models\User;
use App\Repositories\TwoFactorRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class ValidateTwoFactorUseCase {
    public function __construct(
        private TwoFactorRepositoryInterface $twoFactorRepository,
        private Google2FA $google2FA
    ) {}

    public function handle($user, string $code): bool {
        $secret = $this->twoFactorRepository->getSecret($user);

        if(!$secret)
            return false;

        if($this->google2FA->verifyKey($secret, $code)) {
            $user->two_factor_validated_at = now();
            $user->save();

            return true;
        }

        return false;
    }
}

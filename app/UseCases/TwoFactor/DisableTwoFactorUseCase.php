<?php

namespace App\UseCases\TwoFactor;

use App\Repositories\TwoFactorRepositoryInterface;
use PragmaRX\Google2FA\Google2FA;

class DisableTwoFactorUseCase {
    public function __construct(
        private TwoFactorRepositoryInterface $twoFactorRepository,
        private Google2FA $google2FA
    ) {}

    public function handle($user) {
        return $this->twoFactorRepository->disableTwoFactor($user);
    }
}

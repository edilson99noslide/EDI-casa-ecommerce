<?php

namespace App\UseCases\TwoFactor;

use App\Repositories\TwoFactorRepositoryInterface;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\ImageRenderer;

class EnableTwoFactorUseCase {
    public function __construct(
        private TwoFactorRepositoryInterface $twoFactorRepository,
        private Google2FA $google2FA
    ) {}

    public function handle($user): array {
        $secret = $this->google2FA->generateSecretKey();
        $user = $this->twoFactorRepository->enableTwoFactor($user, $secret);

        $qrCodeUrl = $this->google2FA->getQRCodeUrl(
          config('app.name'),
          $user->email,
          $secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(150),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);
        $qrCodeBase64    = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        return [
            'user'         => $user,
            'secret'       => $secret,
            'qrCodeBase64' => $qrCodeBase64,
        ];
    }
}

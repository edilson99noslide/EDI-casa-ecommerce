<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interface
use App\Repositories\UserRepositoryInterface;
use App\Repositories\TwoFactorRepositoryInterface;

// Repository
use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentTwoFactorRepository;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
          TwoFactorRepositoryInterface::class,
          EloquentTwoFactorRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

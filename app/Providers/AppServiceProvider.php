<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Implementations\UserRepository;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Implementations\UserService;
use App\Services\Implementations\AuthService;
use App\Services\AI\AIService;
use App\Services\Contracts\AIServiceInterface;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );

                $this->app->bind(
            AIServiceInterface::class,
            AIService::class
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

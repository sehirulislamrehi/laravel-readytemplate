<?php

namespace App\Providers\Modules\UserModule;

use App\Interfaces\UserModule\User\UserReadInterface;
use App\Interfaces\UserModule\User\UserWriteInterface;
use App\Repositories\UserModule\User\UserReadRepository;
use App\Repositories\UserModule\User\UserWriteRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserReadInterface::class,UserReadRepository::class);
        $this->app->bind(UserWriteInterface::class,UserWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}

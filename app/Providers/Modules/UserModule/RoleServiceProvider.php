<?php

namespace App\Providers\Modules\UserModule;

use App\Interfaces\UserModule\Role\RoleReadInterface;
use App\Interfaces\UserModule\Role\RoleWriteInterface;
use App\Repositories\UserModule\Role\RoleReadRepository;
use App\Repositories\UserModule\Role\RoleWriteRepository;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RoleReadInterface::class,RoleReadRepository::class);
        $this->app->bind(RoleWriteInterface::class,RoleWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}

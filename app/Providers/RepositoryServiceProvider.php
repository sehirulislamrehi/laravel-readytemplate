<?php

namespace App\Providers;

use App\Interfaces\CnRequestInterface;
use App\Interfaces\UserInterface;
use App\Repositories\CnRequestRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //user repository
        $this->app->bind(UserInterface::class,UserRepository::class);
        //Cn request repository
        $this->app->bind(CnRequestInterface::class,CnRequestRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

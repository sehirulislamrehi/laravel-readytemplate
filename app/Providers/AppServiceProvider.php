<?php

namespace App\Providers;

use App\Traits\FilePathTrait;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    use FilePathTrait;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $get_file_path = asset($this->get_file_path("profile"));

        View::share([
            'get_file_path' => $get_file_path
        ]);
    }
}

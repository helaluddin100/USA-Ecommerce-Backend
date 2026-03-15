<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        // Suppress deprecation notices (e.g. PDO::MYSQL_ATTR_SSL_CA on PHP 8.5)
        if (app()->environment('local')) {
            error_reporting(error_reporting() & ~E_DEPRECATED);
        }
    }
}

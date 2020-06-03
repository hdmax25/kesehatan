<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Builder::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
      Blade::if('admin', static function () {
        return (Auth::user() && Auth::user()->role == 1);
      });

      Blade::if('kadiv', static function () {
        return (Auth::user() && Auth::user()->role == 2);
      });

      Blade::if('user', static function () {
        return (Auth::user() && Auth::user()->role == 3);
      });
    }
}

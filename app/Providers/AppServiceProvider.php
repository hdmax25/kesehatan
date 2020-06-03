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

    // App\Providers\AppServiceProvider

      public function boot()
      {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

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

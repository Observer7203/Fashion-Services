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
    public function boot()
    {
        // Устанавливаем язык для всех запросов (и для Blade)
        app()->setLocale(session('locale', config('app.locale')));
        view()->composer('*', function ($view) {
            $view->with('siteLang', session('locale', config('app.locale')));
        });
    }    
}

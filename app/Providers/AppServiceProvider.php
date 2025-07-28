<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use App\Observers\ServiceObserver;
use App\Models\Tour;
use App\Observers\TourObserver;


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
     Service::observe(ServiceObserver::class);
     Tour::observe(TourObserver::class);
 }

}

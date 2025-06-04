<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
        
        if (app()->environment('local')) {
            \DB::listen(function ($query) {
                \Log::info([
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ]);
            });
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
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
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(20)->by($request->ip()) );

        RateLimiter::for('admin', fn (Request $request) => Limit::perMinute(100)->by($request->ip()) );

        RateLimiter::for('public', fn (Request $request) => Limit::perMinute(60)->by($request->ip()) );
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

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
        //global api 
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(100)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'too many requests - global limit reached',
                        'retry_after' => '60 seconds'
                    ], 429);
                });
        });


        //login - limit brute force
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'too many login attempts - try again in 60s',
                        'retry_again' => '60  seconds'
                    ], 429);
                });
        });

        //redemption - per authenticated user
        RateLimiter::for('redemption', function (Request $request) {
            return Limit::perMinute(30)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'too many redemption requests',
                        'retry_after' => '60 seconds'
                    ], 429);
                });
        });

        //ticket scanning - higher cuz scanner is fast
        RateLimiter::for('scanning', function (Request $request){
            return Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'scanning rate limit reached',
                        'retry_after' => '60 seconds'
                    ], 429);
                });
        });

        //list guest - low
        RateLimiter::for('guest-list', function (Request $request) {
            return Limit::perMinute(20)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'too many list request',
                        'retry_after' => '60 seconds'
                    ], 429);
                });
        });
    }
}

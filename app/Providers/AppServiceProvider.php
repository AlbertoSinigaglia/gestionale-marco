<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            $trustedHeaders = [
                Request::HEADER_X_FORWARDED_FOR,
                Request::HEADER_X_FORWARDED_PROTO,
                Request::HEADER_X_FORWARDED_PORT,
            ];
            Request::setTrustedProxies(
                array($_SERVER['REMOTE_ADDR']),
                array_reduce($trustedHeaders, function($carry, $value) {
                    return $carry ^ $value;
                }, 0)
            );
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}

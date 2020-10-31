<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class HttpsProtocolMiddleware
{
    public function handle($request, Closure $next)
    {
        Request::setTrustedProxies([$request->getClientIp()],Request::HEADER_X_FORWARDED_ALL);
        if (!$request->secure() && app()->environment('production')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
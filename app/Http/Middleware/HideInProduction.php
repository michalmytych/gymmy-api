<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HideInProduction
{
    /**
     * Hide route with this middleware when running in production.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!config('app.debug')) {
            return abort(404);
        }

        return $next($request);
    }
}

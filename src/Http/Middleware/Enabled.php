<?php

namespace Pabloleone\ArtisanUi\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Enabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('artisan-ui.enabled') !== true) {
            return response('', 404);
        }

        return $next($request);
    }
}

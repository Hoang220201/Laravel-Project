<?php

namespace App\Http\Middleware;

use Closure;

class UnlimitedAccessURL
{
    public function handle($request, Closure $next)
    {

        $url = $request->url();
        
        if (strpos($url, 'php') !== false) {
            return $next($request);
        }

        abort(401, 'Unauthorized');
    }
}

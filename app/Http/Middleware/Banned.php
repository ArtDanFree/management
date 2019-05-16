<?php

namespace App\Http\Middleware;

use Closure;

class Banned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Gate::allows('banned')) {
            return \Redirect::route('banned');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (\Gate::denies('admin')) {
            return \Redirect::route('home')->withErrors('Вы не администратор');
        }
        return $next($request);
    }
}

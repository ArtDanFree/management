<?php

namespace App\Http\Middleware;

use Closure;

class leadInfo
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
        if (\Gate::allows('lead')) {
            if ($request->user()->email == null or
                $request->user()->first_name == null or
                $request->user()->last_name == null or
                $request->user()->surname == null or
                $request->user()->organization == null or
                $request->user()->credit_card_number == null or
                $request->user()->personal_acc == null or
                $request->user()->correspondent_acc == null or
                $request->user()->bic_bank == null or
                $request->user()->name_bank == null
            )
            {
                return \Redirect::route('user.edit', $request->user())->withErrors(__('error.complete_your_profile'));
            }
        }

        if (\Gate::allows('underwriter')) {
            if ($request->user()->first_name == null or
                $request->user()->last_name == null or
                $request->user()->surname == null
            )
            {
                return \Redirect::route('user.edit', $request->user())->withErrors(__('error.complete_your_profile'));
            }
        }
        return $next($request);
    }
}

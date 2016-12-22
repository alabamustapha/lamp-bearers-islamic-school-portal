<?php

namespace App\Http\Middleware;

use Closure;

class VerifyLicenceKey
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

        if(get_licence_key() == "" || !has_valid_licence_key()) {
            return redirect('add_licence')->with('message', 'You do not have a valid licence key');
        }

        return $next($request);

    }
}

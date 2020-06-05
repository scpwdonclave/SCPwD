<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfNotCenter
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'center')
	{
	    if (!Auth::guard($guard)->check()) {
			Session::put('backUrl', URL::current());
			return redirect()->route( $guard.'.login' )->with('warning', 'Session has expired kindly re-login.');
	    }

	    return $next($request);
	}
}
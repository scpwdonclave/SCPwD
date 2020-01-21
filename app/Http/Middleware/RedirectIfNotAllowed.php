<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class RedirectIfNotAllowed
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
        if (!is_null(Request::segment(1)) && in_array(Request::segment(1), ['admin','partner','agency','center','assessor'])) {
            if (Auth::guard(Request::segment(1))->check()) {
                switch (Request::segment(1)) {
                    case 'admin':
                            if (!Auth::guard('admin')->user()->status) {
                                Auth::guard('admin')->logout();
                                $request->session()->flush();
                                $request->session()->regenerate();
                                return redirect()->route( 'admin.login' )->with('warning', 'Your session has expired because your account is deactivated.');
                            }
                        break;
                    case 'partner':
                            if (!Auth::guard('partner')->user()->status) {
                                Auth::guard('partner')->logout();
                                $request->session()->flush();
                                $request->session()->regenerate();
                                return redirect()->route( 'partner.login' )->with('warning', 'Your session has expired because your account is deactivated.');
                            }
                        break;
                    case 'agency':
                            if (!Auth::guard('agency')->user()->status) {
                                Auth::guard('agency')->logout();
                                $request->session()->flush();
                                $request->session()->regenerate();
                                return redirect()->route( 'agency.login' )->with('warning', 'Your session has expired because your account is deactivated.');
                            }
                        break;
                    case 'center':
                            if (!Auth::guard('center')->user()->status || !Auth::guard('center')->user()->partner->status) {
                                Auth::guard('center')->logout();
                                $request->session()->flush();
                                $request->session()->regenerate();
                                return redirect()->route( 'center.login' )->with('warning', 'Your session has expired because your account is deactivated.');
                            }
                        break;
                    case 'assessor':
                            if (!Auth::guard('assessor')->user()->status || !Auth::guard('assessor')->user()->agency->status) {
                                Auth::guard('assessor')->logout();
                                $request->session()->flush();
                                $request->session()->regenerate();
                                return redirect()->route( 'assessor.login' )->with('warning', 'Your session has expired because your account is deactivated.');
                            }
                        break;
                }
            }
        }
        return $next($request);
    }
}

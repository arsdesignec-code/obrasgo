<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Helpers\helper;

class AuthMiddleware
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
        if (!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }
        helper::language();
        if (Auth::user()) {
            if (Auth::user()->type == "1" || Auth::user()->type == "2" || Auth::user()->type == "3") {
                return $next($request);
            }
            return redirect()->back();
        }
        Auth::logout();
        return redirect(route('adminlogin'));
    }
}

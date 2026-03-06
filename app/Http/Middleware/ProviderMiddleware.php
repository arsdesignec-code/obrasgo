<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Helpers\helper;

class ProviderMiddleware
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
        if (Auth::user() && Auth::user()->type == "2" || Auth::user()->type == "3") {
            return $next($request);
        }
        return redirect()->back();
        // return redirect(route('dashboard'));
    }
}

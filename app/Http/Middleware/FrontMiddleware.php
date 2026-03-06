<?php

namespace App\Http\Middleware;

use App\Helpers\helper;
use Closure;
use Illuminate\Http\Request;

class FrontMiddleware

{

    /**

     * Handle an incoming request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next

     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse

     */

    public function handle(Request $request, Closure $next)
    {
        if (!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }

        if (@helper::otherdata()->maintenance_on_off == 1) {
              return response(view('errors.maintenance'));
        }
        return $next($request);
    }
}

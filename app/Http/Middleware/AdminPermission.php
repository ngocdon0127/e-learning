<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminPermission
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
        if (!Auth::check() or auth()->user()->admin != 1) {
                    return view('errors.404');
                }
        return $next($request);
    }
}

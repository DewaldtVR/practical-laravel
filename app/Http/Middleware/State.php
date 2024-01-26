<?php

namespace App\Http\Middleware;

use App\Traits\MenuExpose;
use Closure;
use Illuminate\Support\Facades\Session;

class State
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Session::forget("main");
        Session::forget("top");
        MenuExpose::exposeMenus();

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class HasRight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $right_slug)
    {
        if (!$request->user()->hasRight($right_slug)) {
            return redirect()->route('home')->with('warning', 'Access denied');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config()->set('auth.defaults.guard', 'api');

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid'])
                    ->setStatusCode(401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired'])
                    ->setStatusCode(401);
            } else {
                return response()->json(['error' => 'Authorization Token not found'])
                    ->setStatusCode(401);
            }
        }
        return $next($request);
    }
}

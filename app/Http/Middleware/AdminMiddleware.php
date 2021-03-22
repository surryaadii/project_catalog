<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class AdminMiddleware
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
        $cookie = \Cookie::get('auth_token');
        if ($cookie) {
            $user = JWTAuth::setToken($cookie)->toUser();
            if($user && $user->isAdmin) return $next($request);
        }
        return redirect()->route('admin.login');
    }
}

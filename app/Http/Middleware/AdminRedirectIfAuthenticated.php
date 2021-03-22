<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class AdminRedirectIfAuthenticated
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
            if($user && $user->isAdmin) return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}

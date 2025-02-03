<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class verifyDeviceTokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionToken = session('device_token');

            if (isset($user->device_token) && $user->device_token != $sessionToken) {
                Auth::logout();
                return [
                    'code'  => 401,
                    'key'   => 'failed',
                    'msg'   => 'session expired',
                ];
            }
        }

        return $next($request);
    }
}

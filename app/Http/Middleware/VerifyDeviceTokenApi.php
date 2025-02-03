<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyDeviceTokenApi
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionToken = session('device_token');

            if (isset($user->device_token) && $user->device_token != $sessionToken) {
//                Auth::logout();
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

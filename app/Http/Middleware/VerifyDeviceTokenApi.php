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
            if (is_null($user->device_token)) {
                return response()->json([
                    'code'  => 401,
                    'key'   => 'unauthenticated',
                    'msg'   => 'please login again',
                ]);
            }
        }

        return $next($request);
    }
}

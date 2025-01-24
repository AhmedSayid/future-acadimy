<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyDeviceToken
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionToken = session('device_token');

            if ($user->device_token != $sessionToken) {
                Auth::logout();
                return redirect('/login')->withErrors(['session_error' => 'You have been logged out because your account is active on another device.']);
            }
        }

        return $next($request);
    }
}

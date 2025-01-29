<?php

namespace App\Http\Middleware;

use App\Enums\RoleType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            if ($userRole == RoleType::STUDENT) {
                return redirect('/platform/home')->withErrors(['Auth error' => 'ليس لديك صلاحية لهذه الصفحه']);
            }
        }

        return $next($request);
    }
}

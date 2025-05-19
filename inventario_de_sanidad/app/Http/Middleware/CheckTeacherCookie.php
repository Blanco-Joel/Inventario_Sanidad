<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class CheckTeacherCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        if ($request->cookie('TYPE') == "teacher") {
            // Si no existe la cookie, se puede redirigir o abortar
            return $next($request);

        }
        if ($request->cookie('TYPE') == "admin") {
            // Si no existe la cookie, se puede redirigir o abortar
            return $next($request);
        }
        return redirect()->route('logout');

    }
}


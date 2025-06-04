<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->approved_by_admin) {
            \Illuminate\Support\Facades\Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your account is waiting for admin approval.');
        }

        return $next($request);
    }
}

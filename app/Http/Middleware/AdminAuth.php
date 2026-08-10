<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('admin_logged_in')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Silakan login terlebih dahulu.'], 401);
            }
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}

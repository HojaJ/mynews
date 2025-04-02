<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('user_id') || session('user_role') !== 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('cashier.dashboard')
                ->with('danger', 'Akses ditolak! Hanya admin yang dapat mengakses.');
        }

        return $next($request);
    }
}

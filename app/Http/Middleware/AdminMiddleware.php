<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (! auth()->user()->isAdmin() && ! in_array($request->route()->getName(), [
            'admin.dashboard',
            'admin.reservations.index',
            'admin.reservations.show',
        ])) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}

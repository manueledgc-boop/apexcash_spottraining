<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremiumUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->hasPremiumAccess()) {
            return $next($request);
        }

        return redirect()
            ->route('premium.upgrade')
            ->with('warning', 'Esta función es Premium.');
    }
}
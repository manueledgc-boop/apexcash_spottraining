<?php

namespace App\Http\Middleware;

use App\Services\TrainingProgressionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTrainingStageUnlocked
{
    public function __construct(
        protected TrainingProgressionService $progression
    ) {
    }

    public function handle(Request $request, Closure $next, string $stage): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$this->progression->canAccess($user, $stage)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'locked' => true,
                    'message' => $this->progression->lockedMessage($user, $stage),
                ], 403);
            }

            return redirect()
                ->route('dashboard')
                ->with('warning', $this->progression->lockedMessage($user, $stage));
        }

        return $next($request);
    }
}

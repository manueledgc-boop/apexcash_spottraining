<?php

namespace App\Http\Controllers;

use App\Models\FounderApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FounderApplicationController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->plan === 'founder' || $user->plan === 'admin') {
            return redirect()
                ->route('dashboard')
                ->with('status', 'Ya tienes acceso Founder.');
        }

        $existingApplication = FounderApplication::query()
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if ($existingApplication && $existingApplication->status === 'pending') {
            return redirect()
                ->route('dashboard')
                ->with('status', 'Tu solicitud Founder ya está en revisión.');
        }

        return view('founder.apply', [
            'existingApplication' => $existingApplication,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->plan === 'founder' || $user->plan === 'admin') {
            return redirect()->route('dashboard');
        }

        $pendingApplication = FounderApplication::query()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($pendingApplication) {
            return redirect()
                ->route('dashboard')
                ->with('status', 'Tu solicitud Founder ya está en revisión.');
        }

        $validated = $request->validate([
            'country' => ['nullable', 'string', 'max:80'],
            'poker_experience' => ['required', 'string', 'max:80'],
            'main_format' => ['required', 'string', 'max:80'],
            'usual_level' => ['required', 'string', 'max:80'],
            'motivation' => ['required', 'string', 'min:20', 'max:1000'],
            'expectations' => ['nullable', 'string', 'max:1000'],
            'willing_to_give_feedback' => ['required', 'boolean'],
        ]);

        FounderApplication::create([
            'user_id' => $user->id,
            'country' => $validated['country'] ?? null,
            'poker_experience' => $validated['poker_experience'],
            'main_format' => $validated['main_format'],
            'usual_level' => $validated['usual_level'],
            'motivation' => $validated['motivation'],
            'expectations' => $validated['expectations'] ?? null,
            'willing_to_give_feedback' => (bool) $validated['willing_to_give_feedback'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Solicitud Founder enviada. La revisaremos pronto.');
    }
}
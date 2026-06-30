<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FounderApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FounderApplicationAdminController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $applications = FounderApplication::query()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.founders.index', compact('applications'));
    }

    public function show(FounderApplication $application): View
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $application->load('user', 'reviewer');

        return view('admin.founders.show', compact('application'));
    }

    public function approve(FounderApplication $application): RedirectResponse
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $user = $application->user;

        $user->update([
            'plan' => 'founder',
            'premium_until' => null,
        ]);

        $application->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.founders.show', $application)
            ->with('status', 'Solicitud aprobada. El usuario ahora es Founder Member.');
    }

    public function reject(FounderApplication $application): RedirectResponse
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $application->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.founders.show', $application)
            ->with('status', 'Solicitud rechazada.');
    }
}
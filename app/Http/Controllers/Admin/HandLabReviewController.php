<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HandLabSpot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class HandLabReviewController extends Controller
{
    public function index(): View
    {
        $this->ensureAdmin();

        $pendingSpots = HandLabSpot::query()
            ->with('user')
            ->where('review_status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.hand-lab.index', [
            'pendingSpots' => $pendingSpots,
        ]);
    }

    public function show(HandLabSpot $spot): View
    {
        $this->ensureAdmin();

        return view('admin.hand-lab.show', [
            'spot' => $spot->load('user'),
            'rejectionReasons' => $this->rejectionReasons(),
        ]);
    }

    public function approve(Request $request, HandLabSpot $spot): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'best_action' => ['required', 'string', 'max:80'],
            'gto_explanation' => ['required', 'string', 'max:3000'],
            'exploit_explanation' => ['nullable', 'string', 'max:3000'],
            'leak_label' => ['nullable', 'string', 'max:120'],
            'concepts' => ['nullable', 'string', 'max:500'],
            'review_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $spot->forceFill([
            'best_action' => $validated['best_action'],
            'gto_explanation' => $validated['gto_explanation'],
            'exploit_explanation' => $validated['exploit_explanation'] ?? null,
            'leak_label' => $validated['leak_label'] ?? null,
            'concepts' => $this->parseConcepts($validated['concepts'] ?? ''),
            'source_type' => 'community',
            'visibility' => 'public',
            'review_status' => 'approved',
            'analysis_status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'review_reason' => null,
            'review_note' => $validated['review_note'] ?? null,
            'analysis_version' => 'admin_review_v1',
            'used_ai' => false,
            'user_seen_at' => null,
        ])->save();

        return redirect()
            ->route('admin.hand-lab.index')
            ->with('status', __('hand_lab.admin_approved_success'));
    }

    public function reject(Request $request, HandLabSpot $spot): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'review_reason' => ['required', 'string', 'max:80'],
            'review_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $spot->forceFill([
            'visibility' => 'private',
            'review_status' => 'rejected',
            'analysis_status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'review_reason' => $validated['review_reason'],
            'review_note' => $validated['review_note'] ?? null,
            'source_type' => 'user_lab',
            'user_seen_at' => null,
        ])->save();

        return redirect()
            ->route('admin.hand-lab.index')
            ->with('status', __('hand_lab.admin_rejected_success'));
    }

    private function ensureAdmin(): void
    {
        abort_if(! Auth::check() || ! Auth::user()->is_admin, Response::HTTP_FORBIDDEN);
    }

    private function rejectionReasons(): array
    {
        return [
            'insufficient_information' => __('hand_lab.reason_insufficient_information'),
            'invalid_sequence' => __('hand_lab.reason_invalid_sequence'),
            'duplicate' => __('hand_lab.reason_duplicate'),
            'low_quality' => __('hand_lab.reason_low_quality'),
            'other' => __('hand_lab.reason_other'),
        ];
    }

    private function parseConcepts(string $concepts): array
    {
        return collect(explode(',', $concepts))
            ->map(fn (string $concept): string => trim($concept))
            ->filter()
            ->values()
            ->all();
    }
}

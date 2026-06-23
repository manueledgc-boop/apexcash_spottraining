<?php

namespace App\Http\Controllers;

use App\Models\HandLabSpot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class HandLabController extends Controller
{
    public function index(): View
    {
        return view('hand-lab.index', [
            'reviewCount' => $this->pendingUserReviewCount(),
        ]);
    }

    public function reviews(): View
    {
        $reviews = HandLabSpot::query()
            ->where('user_id', Auth::id())
            ->whereIn('review_status', ['pending', 'approved', 'rejected'])
            ->whereNull('user_seen_at')
            ->orderByRaw("CASE WHEN review_status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('hand-lab.reviews', [
            'reviews' => $reviews,
        ]);
    }

    public function showReview(HandLabSpot $spot): View
    {
        abort_if((int) $spot->user_id !== (int) Auth::id(), Response::HTTP_FORBIDDEN);

        if (in_array($spot->review_status, ['approved', 'rejected'], true) && is_null($spot->user_seen_at)) {
            $spot->forceFill(['user_seen_at' => now()])->save();
        }

        return view('hand-lab.review-show', [
            'spot' => $spot,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'format' => ['required', 'string', 'max:40'],
            'street' => ['required', 'string', 'max:20'],
            'spot_type' => ['nullable', 'string', 'max:120'],
            'hero_position' => ['required', 'string', 'max:10'],
            'villain_position' => ['required', 'string', 'max:10'],
            'hero_cards' => ['required', 'array', 'size:2'],
            'hero_cards.*' => ['required', 'string', 'max:3'],
            'board_cards' => ['nullable', 'array'],
            'board_cards.*' => ['nullable', 'string', 'max:3'],
            'pot_bb' => ['required', 'numeric', 'min:0'],
            'spr' => ['nullable', 'numeric', 'min:0'],
            'effective_stack_bb' => ['required', 'numeric', 'min:0'],
            'actions' => ['required', 'array'],
            'active_players' => ['nullable', 'array'],
            'options' => ['nullable', 'array'],
            'selected_action' => ['required', 'string', 'max:40'],
        ]);

        $validated = HandLabClassifier::enrichPayload($validated);

        $match = $this->similarity->findBestMatch($validated);

        if ($match) {
            return response()->json([
                'status' => 'matched_library',
                'message' => __('hand_lab.saved_matched_library'),
                'selected_action' => $validated['selected_action'],
                'best_action' => $match['best_action'] ?? null,
                'gto_explanation' => $match['gto_explanation'] ?? null,
                'exploit_explanation' => $match['exploit_explanation'] ?? null,
                'leak_label' => $match['leak_label'] ?? null,
                'concepts' => $match['concepts'] ?? [],
                'source_type' => $match['source_type'] ?? 'official',
                'source_label' => $match['source_label'] ?? __('hand_lab.source_official_library'),
                'matched_spot_id' => $match['id'] ?? null,
                'similarity_score' => $match['similarity_score'] ?? null,
            ]);
        }

        $spot = HandLabSpot::create([
            'user_id' => Auth::id(),
            'format' => $validated['format'],
            'street' => $validated['street'],
            'spot_type' => $validated['spot_type'] ?? null,
            'normalized_signature' => $signature,
            'hero_position' => $validated['hero_position'],
            'villain_position' => $validated['villain_position'],
            'hero_cards' => $validated['hero_cards'],
            'board_cards' => $validated['board_cards'] ?? [],
            'pot_bb' => $validated['pot_bb'],
            'spr' => $validated['spr'] ?? null,
            'effective_stack_bb' => $validated['effective_stack_bb'],
            'action_history' => $validated['actions'],
            'active_players' => $validated['active_players'] ?? [],
            'options' => $validated['options'] ?? [],
            'selected_action' => $validated['selected_action'],
            'best_action' => null,
            'gto_explanation' => null,
            'exploit_explanation' => null,
            'concepts' => [],
            'leak_label' => null,
            'source_type' => 'user_lab',
            'visibility' => 'private',
            'review_status' => 'pending',
            'analysis_status' => 'pending_review',
            'matched_spot_id' => null,
            'used_ai' => false,
            'analysis_version' => null,
            'raw_payload' => $validated,
            'spot_family' => $validated['spot_family'],
            'spot_family_label' => $validated['spot_family_label'],
        ]);

        return response()->json([
            'status' => 'pending_review',
            'spot_id' => $spot->id,
            'message' => __('hand_lab.saved_pending_review'),
            'selected_action' => $spot->selected_action,
            'best_action' => null,
            'gto_explanation' => null,
            'exploit_explanation' => null,
            'leak_label' => null,
        ]);
    }


    private function pendingUserReviewCount(): int
    {
        return HandLabSpot::query()
            ->where('user_id', Auth::id())
            ->whereIn('review_status', ['pending', 'approved', 'rejected'])
            ->whereNull('user_seen_at')
            ->count();
    }
}
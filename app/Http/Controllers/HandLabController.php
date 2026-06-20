<?php

namespace App\Http\Controllers;

use App\Models\HandLabSpot;
use App\Services\HandLabSimilarityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\SpotTraining\SpotFamilyResolver;

class HandLabController extends Controller
{
    public function __construct(protected HandLabSimilarityService $similarity)
    {
    }

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

        if (strtolower($validated['street']) === 'preflop') {
            $validated['spot_family'] = SpotFamilyResolver::fromCards($validated['hero_cards']);
            $validated['spot_family_label'] = SpotFamilyResolver::labelFromFamily($validated['spot_family']);
        } else {
            $validated['spot_family'] = null;
            $validated['spot_family_label'] = null;
        }

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

        $signature = $this->signatureFromPayload($validated);

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

    private function signatureFromPayload(array $payload): string
    {
        $actions = collect($payload['actions'] ?? [])
            ->reject(fn ($action) => (bool) ($action['locked'] ?? false))
            ->map(fn ($action) => implode(':', [
                strtolower($action['street'] ?? ''),
                strtoupper($action['actor'] ?? ''),
                strtolower($action['type'] ?? ''),
                $this->sizeBucket((float) ($action['size'] ?? 0)),
            ]))
            ->values()
            ->implode('|');

        $boardCount = count($payload['board_cards'] ?? []);
        $sprBucket = $this->sprBucket((float) ($payload['spr'] ?? 0));

        return strtoupper(implode('__', array_filter([
            $payload['street'] ?? 'unknown',
            $payload['hero_position'] ?? 'hero',
            $payload['villain_position'] ?? 'villain',
            preg_replace('/\s+/', '_', $payload['spot_type'] ?? 'unknown'),
            'BOARD_' . $boardCount,
            'SPR_' . $sprBucket,
            md5($actions),
        ])));
    }

    private function sizeBucket(float $size): string
    {
        if ($size <= 0) {
            return 'none';
        }

        if ($size <= 1.5) {
            return 'small';
        }

        if ($size <= 3.5) {
            return 'standard';
        }

        if ($size <= 8) {
            return 'large';
        }

        return 'allin_or_huge';
    }

    private function sprBucket(float $spr): string
    {
        if ($spr <= 0) {
            return 'unknown';
        }

        if ($spr <= 2) {
            return 'low';
        }

        if ($spr <= 6) {
            return 'medium';
        }

        return 'high';
    }
}

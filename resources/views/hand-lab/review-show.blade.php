<x-app-layout>
    <link href="{{ asset('assets/css/hand-lab.css') }}" rel="stylesheet">

    @php
        $isPending = $spot->review_status === 'pending';
        $isApproved = $spot->review_status === 'approved';
        $isRejected = $spot->review_status === 'rejected';
        $sourceLabel = $isApproved
            ? __('hand_lab.source_community_library')
            : __('hand_lab.pending_review_source');
    @endphp

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker">{{ __('hand_lab.my_hand_reviews_kicker') }}</span>
                <h1>{{ $spot->spot_type ?: __('hand_lab.lab_spot') }}</h1>
                <p>{{ $spot->hero_position }} vs {{ $spot->villain_position }} · {{ strtoupper($spot->street) }}</p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="{{ route('hand-lab.reviews.index') }}" class="ghost-link">{{ __('hand_lab.back_to_reviews') }}</a>
            </div>
        </section>

        <section class="hand-review-detail-layout">
            <article class="lab-box hand-review-detail-card">
                <span class="lab-box-kicker">
                    @if($isPending)
                        {{ __('hand_lab.status_pending') }}
                    @elseif($isApproved)
                        {{ __('hand_lab.status_reviewed') }}
                    @else
                        {{ __('hand_lab.status_not_approved') }}
                    @endif
                </span>

                @if($isPending)
                    <h2>{{ __('hand_lab.review_pending_title') }}</h2>
                    <p>{{ __('hand_lab.review_pending_text') }}</p>
                @elseif($isApproved)
                    <h2>{{ __('hand_lab.review_completed_title') }}</h2>

                    <div class="hand-review-result-grid">
                        <div><strong>{{ __('hand_lab.your_decision') }}</strong><span>{{ $spot->selected_action ?: '--' }}</span></div>
                        <div><strong>{{ __('hand_lab.best_action') }}</strong><span>{{ $spot->best_action ?: '--' }}</span></div>
                    </div>

                    @if($spot->gto_explanation)
                        <h3>GTO</h3>
                        <p>{{ $spot->gto_explanation }}</p>
                    @endif

                    @if($spot->exploit_explanation)
                        <h3>{{ __('hand_lab.micro_limits') }}</h3>
                        <p>{{ $spot->exploit_explanation }}</p>
                    @endif

                    @if($spot->leak_label)
                        <h3>{{ __('hand_lab.leak_detected') }}</h3>
                        <p>{{ $spot->leak_label }}</p>
                    @endif

                    <div class="lab-warning">
                        <strong>{{ __('hand_lab.source') }}:</strong> {{ $sourceLabel }}
                    </div>
                @elseif($isRejected)
                    <h2>{{ __('hand_lab.review_not_approved_title') }}</h2>
                    <p>{{ __('hand_lab.review_not_approved_text') }}</p>

                    <div class="lab-warning">
                        <strong>{{ __('hand_lab.reason') }}:</strong>
                        {{ $spot->review_note ?: $spot->review_reason ?: __('hand_lab.reason_insufficient_information') }}
                    </div>
                @endif
            </article>

            <article class="lab-box hand-review-detail-card">
                <span class="lab-box-kicker">{{ __('hand_lab.previous_action') }}</span>
                <h2>{{ __('hand_lab.action_history') }}</h2>
                <ol class="lab-action-list">
                    @foreach(($spot->action_history ?? []) as $action)
                        <li>
                            {{ strtoupper($action['street'] ?? '') }} ·
                            {{ $action['actor'] ?? '--' }}
                            {{ ucfirst(str_replace('_', ' ', $action['type'] ?? '--')) }}
                            @if(($action['size'] ?? 0) > 0)
                                {{ rtrim(rtrim(number_format((float) $action['size'], 1), '0'), '.') }} BB
                            @endif
                        </li>
                    @endforeach
                </ol>
            </article>
        </section>
    </main>
</x-app-layout>

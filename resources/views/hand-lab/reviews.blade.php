<x-app-layout>
    <link href="{{ asset('assets/css/hand-lab.css') }}" rel="stylesheet">

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker">{{ __('hand_lab.my_hand_reviews_kicker') }}</span>
                <h1>{{ __('hand_lab.my_hand_reviews') }}</h1>
                <p>{{ __('hand_lab.my_hand_reviews_subtitle') }}</p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="{{ route('hand-lab.index') }}" class="ghost-link">{{ __('hand_lab.back_to_hand_lab') }}</a>
            </div>
        </section>

        <section class="hand-review-list">
            @forelse($reviews as $review)
                @php
                    $isPending = $review->review_status === 'pending';
                    $isApproved = $review->review_status === 'approved';
                    $statusLabel = $isPending
                        ? __('hand_lab.status_pending')
                        : ($isApproved ? __('hand_lab.status_reviewed') : __('hand_lab.status_not_approved'));
                @endphp

                <a href="{{ route('hand-lab.reviews.show', $review) }}" class="hand-review-card">
                    <div>
                        <span class="lab-box-kicker">{{ $statusLabel }}</span>
                        <h2>{{ $review->spot_type ?: __('hand_lab.lab_spot') }}</h2>
                        <p>
                            {{ $review->hero_position }} vs {{ $review->villain_position }} · {{ strtoupper($review->street) }} ·
                            {{ __('hand_lab.your_decision') }}: {{ $review->selected_action ?: '--' }}
                        </p>
                    </div>

                    <div class="hand-review-status {{ $isPending ? 'is-pending' : ($isApproved ? 'is-approved' : 'is-rejected') }}">
                        {{ $statusLabel }}
                    </div>
                </a>
            @empty
                <article class="lab-box hand-review-empty">
                    <span class="lab-box-kicker">{{ __('hand_lab.my_hand_reviews') }}</span>
                    <h2>{{ __('hand_lab.no_reviews_title') }}</h2>
                    <p>{{ __('hand_lab.no_reviews_text') }}</p>
                    <a href="{{ route('hand-lab.index') }}" class="primary-lab-btn hand-review-empty-btn">{{ __('hand_lab.create_another_spot') }}</a>
                </article>
            @endforelse
        </section>
    </main>
</x-app-layout>

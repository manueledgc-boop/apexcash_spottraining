<x-app-layout>
    <link href="{{ asset('assets/css/hand-lab.css') }}" rel="stylesheet">

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker">{{ __('hand_lab.admin_kicker') }}</span>
                <h1>{{ __('hand_lab.admin_pending_reviews') }}</h1>
                <p>{{ __('hand_lab.admin_pending_reviews_subtitle') }}</p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="{{ route('hand-lab.index') }}" class="ghost-link">{{ __('hand_lab.back_to_hand_lab') }}</a>
            </div>
        </section>

        @if(session('status'))
            <section class="hand-review-list">
                <article class="lab-box admin-review-alert">
                    {{ session('status') }}
                </article>
            </section>
        @endif

        <section class="hand-review-list">
            @forelse($pendingSpots as $spot)
                <a href="{{ route('admin.hand-lab.show', $spot) }}" class="hand-review-card">
                    <div>
                        <span class="lab-box-kicker">{{ __('hand_lab.status_pending') }}</span>
                        <h2>{{ $spot->spot_type ?: __('hand_lab.lab_spot') }}</h2>
                        <p>
                            #{{ $spot->id }} ·
                            {{ $spot->hero_position }} vs {{ $spot->villain_position }} ·
                            {{ strtoupper($spot->street) }} ·
                            {{ __('hand_lab.your_decision') }}: {{ $spot->selected_action ?: '--' }}
                        </p>
                    </div>

                    <div class="hand-review-status is-pending">
                        {{ __('hand_lab.review_now') }}
                    </div>
                </a>
            @empty
                <article class="lab-box hand-review-empty">
                    <span class="lab-box-kicker">{{ __('hand_lab.admin_pending_reviews') }}</span>
                    <h2>{{ __('hand_lab.admin_no_pending_title') }}</h2>
                    <p>{{ __('hand_lab.admin_no_pending_text') }}</p>
                </article>
            @endforelse

            @if($pendingSpots->hasPages())
                <div class="admin-review-pagination">
                    {{ $pendingSpots->links() }}
                </div>
            @endif
        </section>
    </main>
</x-app-layout>

<x-app-layout>
    <link href="{{ asset('assets/css/hand-lab.css') }}" rel="stylesheet">

    @php
        $cardText = function (?string $card): string {
            if (!$card) return '--';
            $rank = substr($card, 0, -1);
            $suit = substr($card, -1);
            $symbol = ['s' => '♠', 'h' => '♥', 'd' => '♦', 'c' => '♣'][$suit] ?? $suit;
            return $rank.$symbol;
        };

        $formatSize = function ($value): string {
            $number = (float) ($value ?? 0);
            return rtrim(rtrim(number_format($number, 1), '0'), '.');
        };
    @endphp

    <main class="hand-lab-page">
        <section class="hand-lab-header">
            <div>
                <span class="hand-lab-kicker">{{ __('hand_lab.admin_kicker') }}</span>
                <h1>{{ $spot->spot_type ?: __('hand_lab.lab_spot') }}</h1>
                <p>#{{ $spot->id }} · {{ $spot->hero_position }} vs {{ $spot->villain_position }} · {{ strtoupper($spot->street) }}</p>
            </div>

            <div class="hand-lab-header-actions">
                <a href="{{ route('admin.hand-lab.index') }}" class="ghost-link">{{ __('hand_lab.back_to_pending_reviews') }}</a>
            </div>
        </section>

        <section class="hand-review-detail-layout admin-review-layout">
            <article class="lab-box hand-review-detail-card">
                <span class="lab-box-kicker">{{ __('hand_lab.admin_spot_summary') }}</span>
                <h2>{{ __('hand_lab.lab_spot') }}</h2>

                <div class="hand-review-result-grid">
                    <div><strong>{{ __('hand_lab.hero') }}</strong><span>{{ $spot->hero_position }} · {{ collect($spot->hero_cards ?? [])->map($cardText)->implode(' ') }}</span></div>
                    <div><strong>{{ __('hand_lab.villain') }}</strong><span>{{ $spot->villain_position }}</span></div>
                    <div><strong>{{ __('hand_lab.board') }}</strong><span>{{ collect($spot->board_cards ?? [])->map($cardText)->implode(' ') ?: '--' }}</span></div>
                    <div><strong>{{ __('hand_lab.pot') }}</strong><span>{{ $formatSize($spot->pot_bb) }} BB</span></div>
                    <div><strong>SPR</strong><span>{{ $spot->spr ? $formatSize($spot->spr) : '--' }}</span></div>
                    <div><strong>{{ __('hand_lab.your_decision') }}</strong><span>{{ $spot->selected_action ?: '--' }}</span></div>
                </div>

                <h3>{{ __('hand_lab.action_history') }}</h3>
                <ol class="lab-action-list">
                    @foreach(($spot->action_history ?? []) as $action)
                        <li>
                            {{ strtoupper($action['street'] ?? '') }} ·
                            {{ $action['actor'] ?? '--' }}
                            {{ ucfirst(str_replace('_', ' ', $action['type'] ?? '--')) }}
                            @if(($action['size'] ?? 0) > 0)
                                {{ $formatSize($action['size']) }} BB
                            @endif
                        </li>
                    @endforeach
                </ol>
            </article>

            <article class="lab-box hand-review-detail-card admin-review-form-card">
                <span class="lab-box-kicker">{{ __('hand_lab.admin_review_actions') }}</span>
                <h2>{{ __('hand_lab.admin_approve_title') }}</h2>

                <form method="POST" action="{{ route('admin.hand-lab.approve', $spot) }}" class="admin-review-form">
                    @csrf
                    @method('PATCH')

                    <label class="lab-field">
                        <span>{{ __('hand_lab.best_action') }}</span>
                        <input type="text" name="best_action" value="{{ old('best_action') }}" placeholder="Call / Fold / Raise / Bet 75%" required>
                        @error('best_action') <small class="admin-form-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="lab-field">
                        <span>GTO</span>
                        <textarea name="gto_explanation" rows="5" required>{{ old('gto_explanation') }}</textarea>
                        @error('gto_explanation') <small class="admin-form-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="lab-field">
                        <span>{{ __('hand_lab.micro_limits') }}</span>
                        <textarea name="exploit_explanation" rows="5">{{ old('exploit_explanation') }}</textarea>
                        @error('exploit_explanation') <small class="admin-form-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="lab-field">
                        <span>{{ __('hand_lab.leak_detected') }}</span>
                        <input type="text" name="leak_label" value="{{ old('leak_label') }}" placeholder="Overcalling vs 3Bet">
                        @error('leak_label') <small class="admin-form-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="lab-field">
                        <span>{{ __('hand_lab.admin_concepts') }}</span>
                        <input type="text" name="concepts" value="{{ old('concepts') }}" placeholder="BTN vs BB, 3Bet Pot, Preflop">
                        @error('concepts') <small class="admin-form-error">{{ $message }}</small> @enderror
                    </label>

                    <button type="submit" class="primary-lab-btn admin-review-submit">
                        {{ __('hand_lab.admin_approve_button') }}
                    </button>
                </form>

                <hr class="admin-review-divider">

                <h2>{{ __('hand_lab.admin_reject_title') }}</h2>
                <form method="POST" action="{{ route('admin.hand-lab.reject', $spot) }}" class="admin-review-form">
                    @csrf
                    @method('PATCH')

                    <label class="lab-field">
                        <span>{{ __('hand_lab.reason') }}</span>
                        <select name="review_reason" required>
                            @foreach($rejectionReasons as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('review_reason') <small class="admin-form-error">{{ $message }}</small> @enderror
                    </label>

                    <label class="lab-field">
                        <span>{{ __('hand_lab.admin_optional_note') }}</span>
                        <textarea name="review_note" rows="4">{{ old('review_note') }}</textarea>
                        @error('review_note') <small class="admin-form-error">{{ $message }}</small> @enderror
                    </label>

                    <button type="submit" class="secondary-lab-btn admin-review-reject">
                        {{ __('hand_lab.admin_reject_button') }}
                    </button>
                </form>
            </article>
        </section>
    </main>
</x-app-layout>

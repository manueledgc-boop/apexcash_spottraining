<x-app-layout>
    <link href="{{ asset('assets/css/certification-index.css') }}" rel="stylesheet">

    <main class="cert-page">
        <div class="cert-shell">
            @if(session('error'))
                <div class="cert-alert cert-alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="cert-alert cert-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <section class="cert-hero">
                <div class="cert-hero-content">
                    <span class="cert-kicker">{{ __('certification.kicker') }}</span>
                    <h1>{{ __('certification.hero_title') }}</h1>
                    <p>
                        {!! __('certification.hero_text', [
                            'stages' => __('certification.hero_stages'),
                        ]) !!}
                    </p>
                    <p class="cert-hero-note">
                        {{ __('certification.hero_note') }}
                    </p>
                </div>

                <div class="cert-status-card">
                    <div class="cert-status-icon">
                        @if($passedAttempt)
                            🎓
                        @elseif(!$certificationUnlocked)
                            🔒
                        @elseif($activeAttempt)
                            ⏳
                        @else
                            ✅
                        @endif
                    </div>
                    <div class="cert-status-label">{{ __('certification.status') }}</div>
                    <div class="cert-status-value">
                        @if($passedAttempt)
                            {{ __('certification.status_passed') }}
                        @elseif(!$certificationUnlocked)
                            {{ __('certification.status_locked') }}
                        @elseif($activeAttempt)
                            {{ __('certification.status_active') }}
                        @else
                            {{ __('certification.status_available') }}
                        @endif
                    </div>
                </div>
            </section>

            @php
                $stages = [
                    [__('certification.stage_preflop'), '✅'],
                    [__('certification.stage_flop'), '✅'],
                    [__('certification.stage_turn'), '✅'],
                    [__('certification.stage_river'), '✅'],
                    [__('certification.stage_mastery'), '✅'],
                    [__('certification.stage_certification'), $passedAttempt ? '🎓' : ($certificationUnlocked ? '⏳' : '🔒'), true],
                ];
            @endphp

            <section class="cert-route-card">
                <div class="cert-section-head">
                    <span>{{ __('certification.route_title') }}</span>
                    <strong>{{ __('certification.route_subtitle') }}</strong>
                </div>

                <div class="cert-route">
                    @foreach($stages as $stage)
                        @php
                            $label = $stage[0];
                            $icon = $stage[1];
                            $isFinal = $stage[2] ?? false;
                        @endphp

                        <div class="cert-route-step {{ $isFinal ? 'is-final' : '' }}">
                            <div class="cert-route-icon">{{ $icon }}</div>
                            <div class="cert-route-title">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="cert-info-grid">
                <article class="cert-info-card cert-exam-card">
                    <div class="cert-card-icon">🧩</div>
                    <h2>{{ __('certification.exam_structure') }}</h2>
                    <div class="cert-big-number">75</div>
                    <p>{{ __('certification.total_questions') }}</p>

                    <div class="cert-block-list">
                        <span>15 {{ __('certification.stage_preflop') }}</span>
                        <span>15 {{ __('certification.stage_flop') }}</span>
                        <span>15 {{ __('certification.stage_turn') }}</span>
                        <span>15 {{ __('certification.stage_river') }}</span>
                        <span>15 {{ __('certification.stage_mastery') }}</span>
                    </div>
                </article>

                <article class="cert-info-card">
                    <div class="cert-card-icon">🎯</div>
                    <h2>{{ __('certification.passing_requirements') }}</h2>

                    <div class="cert-requirements">
                        <div>
                            <strong>75%</strong>
                            <span>{{ __('certification.global_minimum') }}</span>
                        </div>
                        <div>
                            <strong>60%</strong>
                            <span>{{ __('certification.block_minimum') }}</span>
                        </div>
                    </div>

                    <p class="cert-muted">
                        {{ __('certification.block_warning') }}
                    </p>
                </article>

                <article class="cert-info-card">
                    <div class="cert-card-icon">⏱️</div>
                    <h2>{{ __('certification.exam_rules') }}</h2>

                    <ul class="cert-rules">
                        <li>{{ __('certification.rule_60_minutes') }}</li>
                        <li>{{ __('certification.rule_timer_visible') }}</li>
                        <li>{{ __('certification.rule_answer_required') }}</li>
                        <li>{{ __('certification.rule_can_correct') }}</li>
                        <li>{{ __('certification.rule_no_back') }}</li>
                        <li>{{ __('certification.rule_no_pause') }}</li>
                        <li>{{ __('certification.rule_no_feedback') }}</li>
                    </ul>
                </article>
            </section>

            <section class="cert-action-card">
                @if(!$certificationUnlocked)
                    <div class="cert-action-center">
                        <div class="cert-action-icon">🔒</div>
                        <h2>{{ __('certification.locked_title') }}</h2>
                        <p>{{ __('certification.locked_text') }}</p>
                    </div>
                @elseif($latestAttempt && $latestAttempt->isLockedForRetry())
                    <div class="cert-action-center">
                        <div class="cert-action-icon">⏳</div>
                        <h2>{{ __('certification.retry_locked_title') }}</h2>
                        <p>{{ __('certification.retry_locked_text', ['date' => $latestAttempt->next_attempt_at->format('d/m/Y H:i')]) }}</p>
                    </div>
                @elseif($activeAttempt)
                    <div class="cert-action-split">
                        <div>
                            <span class="cert-kicker">{{ __('certification.active_kicker') }}</span>
                            <h2>{{ __('certification.active_title') }}</h2>
                            <p>{{ __('certification.active_text') }}</p>
                        </div>
                        <a href="{{ route('certification.exam', $activeAttempt) }}" class="cert-main-button">
                            {{ __('certification.continue_exam') }}
                        </a>
                    </div>
                @else
                    <div class="cert-action-split">
                        <div>
                            <span class="cert-kicker">{{ __('certification.before_start') }}</span>
                            <h2>{{ __('certification.start_title') }}</h2>
                            <p>
                                {{ __('certification.start_text') }}
                            </p>
                            <p class="cert-muted">
                                {{ __('certification.possible_results') }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('certification.start') }}">
                            @csrf
                            <button type="submit" class="cert-main-button">
                                {{ __('certification.start_button') }}
                            </button>
                        </form>
                    </div>
                @endif
            </section>

            @if($passedAttempt)
                <section class="cert-passed-card">
                    <div class="cert-passed-icon">🎓</div>
                    <div>
                        <h3>{{ __('certification.passed_title') }}</h3>
                        <p>{{ __('certification.result') }}: <strong>{{ $passedAttempt->resultBadge() }}</strong></p>
                        <p>{{ __('certification.code') }}: <strong>{{ $passedAttempt->certificate_code }}</strong></p>
                    </div>
                </section>
            @endif

            <section class="cert-legal-card">
                <strong>{{ __('certification.legal_note_label') }}</strong>
                {{ __('certification.legal_note_text') }}
            </section>
        </div>
    </main>
</x-app-layout>

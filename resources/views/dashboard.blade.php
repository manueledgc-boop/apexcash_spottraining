<x-app-layout>
    <link href="{{ asset('assets/css/apexcash-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/apexcash-dashboard-polish.css') }}" rel="stylesheet">

    @php
        $total = (int) ($global->total_spots ?? 0);
        $correct = (int) ($global->correct_spots ?? 0);
        $wrong = (int) ($global->wrong_spots ?? 0);
        $accuracy = (float) ($global->accuracy ?? 0);
        $xp = (int) ($global->xp ?? 0);
        $level = (int) ($global->level ?? 1);
        $levelBase = max(0, ($level - 1) * 250);
        $levelProgress = max(0, $xp - $levelBase);
        $levelPercent = min(100, round(($levelProgress / 250) * 100));
    @endphp

    <main class="dashboard-page">
        <section class="dashboard-hero dashboard-hero-v2">
            <div class="dashboard-hero-main">
                <span class="dashboard-badge">{{ __('dashboard.badge') }}</span>

                <h1>{{ __('dashboard.hello', ['name' => auth()->user()->name]) }}</h1>

                <p>{{ __('dashboard.hero_text') }}</p>

                <div class="dashboard-hero-metrics">
                    <div>
                        <span>{{ __('dashboard.level') }}</span>
                        <strong>{{ $level }}</strong>
                    </div>

                    <div>
                        <span>{{ __('dashboard.global_xp') }}</span>
                        <strong>{{ $xp }}</strong>
                    </div>

                    <div>
                        <span>{{ __('dashboard.accuracy') }}</span>
                        <strong>{{ number_format($accuracy, 1) }}%</strong>
                    </div>

                    <div>
                        <span>{{ __('dashboard.spots') }}</span>
                        <strong>{{ $total }}</strong>
                    </div>
                </div>

                <div class="dashboard-next-goal">
                    <span>{{ __('dashboard.next_goal') }}</span>
                    <strong>{{ $nextGoal }}</strong>
                </div>
            </div>

            <div class="dashboard-quick-panel">
                <span class="quick-panel-title">{{ __('dashboard.apexcash_route') }}</span>

                <div class="stage-route-list">
                    <a href="{{ route('spot-training.index') }}" class="stage-route-card is-open">
                        <span>01</span>
                        <div>
                            <strong>{{ __('dashboard.preflop') }}</strong>
                            <small>{{ number_format((float) ($preflopGlobal->accuracy ?? 0), 1) }}% {{ __('dashboard.accuracy_lower') }}</small>
                        </div>
                        <em>{{ __('dashboard.enter') }}</em>
                    </a>

                    @if($flopUnlocked ?? false)
                        <a href="{{ route('postflop-training.index') }}" class="stage-route-card is-open">
                            <span>02</span>
                            <div>
                                <strong>{{ __('dashboard.flop') }}</strong>
                                <small>{{ number_format((float) ($flopGlobal->accuracy ?? 0), 1) }}% {{ __('dashboard.accuracy_lower') }}</small>
                            </div>
                            <em>{{ __('dashboard.enter') }}</em>
                        </a>
                    @else
                        <div class="stage-route-card is-locked">
                            <span>02</span>
                            <div>
                                <strong>{{ __('dashboard.flop') }}</strong>
                                <small>{{ __('dashboard.locked_by_progress') }}</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    @endif

                    @if($turnUnlocked ?? false)
                        <a href="{{ route('postflop-turn.index') }}" class="stage-route-card is-open">
                            <span>03</span>
                            <div>
                                <strong>{{ __('dashboard.turn') }}</strong>
                                <small>{{ number_format((float) ($turnGlobal->accuracy ?? 0), 1) }}% {{ __('dashboard.accuracy_lower') }}</small>
                            </div>
                            <em>{{ __('dashboard.enter') }}</em>
                        </a>
                    @else
                        <div class="stage-route-card is-locked">
                            <span>03</span>
                            <div>
                                <strong>{{ __('dashboard.turn') }}</strong>
                                <small>{{ __('dashboard.locked_by_progress') }}</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    @endif

                    @if($riverUnlocked ?? false)
                        <a href="{{ route('postflop-river.index') }}" class="stage-route-card is-open">
                            <span>04</span>
                            <div>
                                <strong>{{ __('dashboard.river') }}</strong>
                                <small>{{ number_format((float) ($riverGlobal->accuracy ?? 0), 1) }}% {{ __('dashboard.accuracy_lower') }}</small>
                            </div>
                            <em>{{ __('dashboard.enter') }}</em>
                        </a>
                    @else
                        <div class="stage-route-card is-locked">
                            <span>04</span>
                            <div>
                                <strong>{{ __('dashboard.river') }}</strong>
                                <small>{{ __('dashboard.locked_by_progress') }}</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    @endif

                    @if($masteryUnlocked)
                        <a href="{{ route('mastery-training.index') }}" class="stage-route-card is-open">
                            <span>05</span>
                            <div>
                                <strong>{{ __('dashboard.mastery_full') }}</strong>
                                <small>
                                    {{ number_format((float) ($masteryGlobal->accuracy ?? 0), 1) }}% {{ __('dashboard.accuracy_lower') }}
                                </small>
                            </div>
                            <em>{{ __('dashboard.enter') }}</em>
                        </a>
                    @else
                        <div class="stage-route-card is-locked">
                            <span>05</span>
                            <div>
                                <strong>{{ __('dashboard.mastery_full') }}</strong>
                                <small>{{ __('dashboard.locked_by_progress') }}</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    @endif

                    @if($certificationUnlocked ?? false)
                        <a href="{{ route('certification.index') }}" class="stage-route-card is-open">
                            <span>06</span>
                            <div>
                                <strong>{{ __('dashboard.certification') }}</strong>
                                <small>{{ __('dashboard.final_exam_available') }}</small>
                            </div>
                            <em>{{ __('dashboard.enter') }}</em>
                        </a>
                    @else
                        <div class="stage-route-card is-locked">
                            <span>06</span>
                            <div>
                                <strong>{{ __('dashboard.certification') }}</strong>
                                <small>{{ __('dashboard.locked_by_progress') }}</small>
                            </div>
                            <em>🔒</em>
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <section class="dashboard-grid">
            <article class="dashboard-card active">
                <span>🚀 Founder Members 2026</span>

                @if(auth()->user()->plan === 'founder')
                    <h2>Founder Member #{{ str_pad(auth()->user()->founder_number ?? 1, 4, '0', STR_PAD_LEFT) }}</h2>
                    <p>
                        Ya formas parte del programa Founder Members 2026.
                        Tienes acceso anticipado a las funciones avanzadas de ApexCash Trainer.
                    </p>
                    <strong>🏅 Badge Founder desbloqueado</strong>

                @elseif(isset($founderApplication) && $founderApplication)
                    @if($founderApplication->status === 'pending')
                        <h2>Solicitud enviada</h2>
                        <p>
                            Tu solicitud está en revisión. Te avisaremos cuando sea evaluada.
                        </p>
                        <strong>🟡 En revisión</strong>

                    @elseif($founderApplication->status === 'rejected')
                        <h2>Solicitud no aprobada</h2>
                        <p>
                            Tu solicitud fue revisada. Podrás seguir usando ApexCash con tu cuenta gratuita.
                        </p>
                        <strong>🔴 No aprobada</strong>
                    @endif

                @else
                    <h2>Solicita acceso Founder</h2>
                    <p>
                        Estamos seleccionando a los primeros jugadores que quieran ayudarnos a construir
                        ApexCash Trainer antes del lanzamiento oficial del 1 de septiembre de 2026.
                    </p>

                    <a href="{{ route('founder.apply') }}" class="apex-btn apex-btn-primary">
                        🚀 Solicitar acceso
                    </a>
                @endif
            </article>
        </section>

        @if ($criticalLeak)
        @php
            $criticalErrors = max(0, (int) $criticalLeak->total - (int) $criticalLeak->correct);
        @endphp

        <section class="critical-leak-panel">
            <div>
                <span>{{ __('dashboard.critical_leak_detected') }}</span>
                <h2>{{ $criticalLeak->module_label }}</h2>
                <p>
                    {{ __('dashboard.critical_leak_text', [
                        'accuracy' => number_format((float) $criticalLeak->accuracy, 1),
                        'errors' => $criticalErrors,
                        'total' => $criticalLeak->total,
                    ]) }}
                </p>
            </div>

            @php
                $criticalLeakRoute = $routeForModule($criticalLeak->module);
            @endphp

            <a href="{{ route($criticalLeakRoute, ['module' => $criticalLeak->module]) }}">
                {{ __('dashboard.practice_now') }}
            </a>
        </section>
    @endif

        <section class="progress-panel">
            <div>
                <span>{{ __('dashboard.level_with_number', ['level' => $level]) }}</span>
                <strong>{{ $xp }} XP</strong>
                <p>{{ __('dashboard.next_goal_with_value', ['goal' => $nextGoal]) }}</p>
            </div>
            <div class="xp-bar" aria-label="{{ __('dashboard.xp_progress_aria') }}">
                <span style="width: {{ $levelPercent }}%"></span>
            </div>
        </section>

        <section class="dashboard-stats">
            <article><span>{{ __('dashboard.completed_spots') }}</span><strong>{{ $total }}</strong></article>
            <article><span>{{ __('dashboard.global_accuracy') }}</span><strong>{{ number_format($accuracy, 1) }}%</strong></article>
            <article><span>{{ __('dashboard.correct') }}</span><strong>{{ $correct }}</strong></article>
            <article><span>{{ __('dashboard.errors') }}</span><strong>{{ $wrong }}</strong></article>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card">
                <span>{{ __('dashboard.apexcash_route') }}</span>
                <h2>{{ __('dashboard.progression') }}</h2>

                <div class="metric-row">
                    <span>{{ __('dashboard.preflop') }}</span>
                    <strong>
                        {{ number_format((float) ($preflopGlobal->accuracy ?? 0), 1) }}%
                        {{ $flopUnlocked ? '✅' : '⏳' }}
                    </strong>
                </div>

                <div class="metric-row">
                    <span>{{ __('dashboard.flop') }}</span>
                    <strong>
                        {{ number_format((float) ($flopGlobal->accuracy ?? 0), 1) }}%
                        @if(!$flopUnlocked)
                            🔒
                        @elseif(!$turnUnlocked)
                            ⏳
                        @else
                            ✅
                        @endif
                    </strong>
                </div>

                <div class="metric-row">
                    <span>{{ __('dashboard.turn') }}</span>
                    <strong>
                        {{ number_format((float) ($turnGlobal->accuracy ?? 0), 1) }}%
                        @if(!$turnUnlocked)
                            🔒
                        @elseif(!$riverUnlocked)
                            ⏳
                        @else
                            ✅
                        @endif
                    </strong>
                </div>

                <div class="metric-row">
                    <span>{{ __('dashboard.river') }}</span>
                    <strong>
                        {{ number_format((float) ($riverGlobal->accuracy ?? 0), 1) }}%
                        @if(!$riverUnlocked)
                            🔒
                        @elseif(!$masteryUnlocked)
                            ⏳
                        @else
                            ✅
                        @endif
                    </strong>
                </div>

                <div class="metric-row">
                    <span>{{ __('dashboard.mastery') }}</span>
                    <strong>
                        {{ number_format((float) ($masteryGlobal->accuracy ?? 0), 1) }}%
                        @if(!$masteryUnlocked)
                            🔒
                        @elseif(!($certificationUnlocked ?? false))
                            ⏳
                        @else
                            🎓
                        @endif
                    </strong>
                </div>

                <div class="metric-row">
                    <span>{{ __('dashboard.certification_short') }}</span>
                    <strong>
                        @if($certificationUnlocked ?? false)
                            {{ __('dashboard.available') }} 🎓
                        @else
                            🔒
                        @endif
                    </strong>
                </div>
            </article>

            <article class="dashboard-card">
                <span>{{ __('dashboard.accuracy_by_stage') }}</span>
                <h2>{{ __('dashboard.training') }}</h2>

                <div class="metric-row"><span>{{ __('dashboard.preflop') }}</span><strong>{{ number_format((float) ($preflopGlobal->accuracy ?? 0), 1) }}%</strong></div>
                <div class="metric-row"><span>{{ __('dashboard.flop') }}</span><strong>{{ number_format((float) ($flopGlobal->accuracy ?? 0), 1) }}%</strong></div>
                <div class="metric-row"><span>{{ __('dashboard.turn') }}</span><strong>{{ number_format((float) ($turnGlobal->accuracy ?? 0), 1) }}%</strong></div>
                <div class="metric-row"><span>{{ __('dashboard.river') }}</span><strong>{{ number_format((float) ($riverGlobal->accuracy ?? 0), 1) }}%</strong></div>
            </article>
        </section>

        <section class="dashboard-grid">
            <article class="dashboard-card active">
                <span>{{ __('dashboard.best_module') }}</span>
                <h2>{{ $bestModule->module_label ?? __('dashboard.not_enough_sample') }}</h2>
                <p>
                    @if ($bestModule)
                        {{ __('dashboard.best_module_text', [
                            'accuracy' => number_format((float) $bestModule->accuracy, 1),
                            'spots' => $bestModule->total_spots,
                        ]) }}
                    @else
                        {{ __('dashboard.need_10_spots_strengths') }}
                    @endif
                </p>
            </article>

            <article class="dashboard-card danger-card">
                <span>{{ __('dashboard.module_to_improve') }}</span>
                <h2>
                    @if ($worstModule)
                        {{ $worstModule->module_label }}
                    @elseif ($bestModule)
                        {{ __('dashboard.not_available_yet') }}
                    @else
                        {{ __('dashboard.not_enough_sample') }}
                    @endif
                </h2>
                <p>
                    @if ($worstModule)
                        {{ __('dashboard.worst_module_text', [
                            'accuracy' => number_format((float) $worstModule->accuracy, 1),
                        ]) }}
                    @elseif ($bestModule)
                        {{ __('dashboard.practice_another_module') }}
                    @else
                        {{ __('dashboard.need_two_modules') }}
                    @endif
                </p>
            </article>

            <a href="{{ route('spot-training.index') }}" class="dashboard-card active">
                <span>{{ __('dashboard.training') }}</span>
                <h2>{{ __('dashboard.preflop_training_title') }}</h2>
                <p>{{ __('dashboard.preflop_training_text') }}</p>
                <strong>{{ __('dashboard.enter_arrow') }}</strong>
            </a>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>{{ __('dashboard.persistent_leaks') }}</span>
                <h2>{{ __('dashboard.weak_modules') }}</h2>
                @forelse ($leaks as $leak)
                    @php
                        $leakRoute = $routeForModule($leak->module);
                    @endphp
                    <a class="metric-row" href="{{ route($leakRoute, ['module' => $leak->module]) }}">
                        <span>{{ $leak->module_label }}</span>
                        <strong>{{ number_format((float) $leak->accuracy, 1) }}% · {{ $leak->total }} {{ __('dashboard.spots_lower') }}</strong>
                    </a>
                @empty
                    <p>{{ __('dashboard.not_enough_answers') }}</p>
                @endforelse
            </article>

            <article class="dashboard-card table-card">
                <span>{{ __('dashboard.worst_spots') }}</span>
                <h2>{{ __('dashboard.concrete_errors') }}</h2>

                @forelse ($worstSpots as $spot)
                    @php
                        $spotRoute = $routeForModule($spot->module);
                    @endphp
                    <a class="metric-row" href="{{ route($spotRoute, ['spot_id' => $spot->spot_id]) }}">
                        <span>
                            {{ $spot->hero_cards ?: __('dashboard.spot') }}
                            ·
                            {{ $spot->concept_label ?: ($spot->spot_title ?: $spot->spot_id) }}
                        </span>

                        <strong>
                            {{ number_format((float) $spot->accuracy, 1) }}%
                            ·
                            {{ $spot->wrong }} {{ __('dashboard.errors_lower') }}
                        </strong>
                    </a>
                @empty
                    <p>{{ __('dashboard.need_more_spots_for_errors') }}</p>
                @endforelse
            </article>
        </section>

        <section class="dashboard-grid two-cols">
            <article class="dashboard-card table-card">
                <span>{{ __('dashboard.stats_by_module') }}</span>
                <h2>{{ __('dashboard.technical_summary') }}</h2>

                @forelse ($moduleStats->take(8) as $stat)
                    @php
                        $acc = (float) $stat->accuracy;

                        if ($acc >= 85) {
                            $badgeClass = 'mastery-dominated';
                            $badgeLabel = __('dashboard.status_dominated');
                        } elseif ($acc >= 60) {
                            $badgeClass = 'mastery-progress';
                            $badgeLabel = __('dashboard.status_progress');
                        } else {
                            $badgeClass = 'mastery-weak';
                            $badgeLabel = __('dashboard.status_weak');
                        }
                    @endphp

                    <div class="metric-row">
                        <div>
                            <span>{{ $stat->module_label }}</span>
                            <div class="mastery-badge {{ $badgeClass }}">
                                {{ $badgeLabel }}
                            </div>
                        </div>

                        <strong>
                            {{ number_format((float) $stat->accuracy, 1) }}%
                            ·
                            {{ $stat->total_spots }} {{ __('dashboard.spots_lower') }}
                        </strong>
                    </div>
                @empty
                    <p>{{ __('dashboard.module_accuracy_empty') }}</p>
                @endforelse
            </article>

            <article class="dashboard-card table-card">
                <span>{{ __('dashboard.concept_leaks') }}</span>
                <h2>{{ __('dashboard.weak_patterns') }}</h2>

                @forelse ($conceptLeaks as $concept)
                    @php
                        $conceptRoute = $routeForModule($concept->module);
                    @endphp
                    <a
                        class="metric-row"
                        href="{{ route($conceptRoute, ['concept' => $concept->concept]) }}"
                    >
                        <span>
                            {{ $concept->concept_label ?: $concept->concept }}

                            @if ($concept->family_label)
                                <small>{{ $concept->family_label }}</small>
                            @endif
                        </span>

                        <strong>
                            {{ number_format((float) $concept->accuracy, 1) }}%
                            ·
                            {{ $concept->wrong }} {{ __('dashboard.errors_lower') }}
                        </strong>
                    </a>
                @empty
                    <p>{{ __('dashboard.taxonomy_empty') }}</p>
                @endforelse
            </article>

            <a href="{{ route('postflop-training.index') }}" class="dashboard-card table-card active">
                <span>{{ __('dashboard.new_training') }}</span>
                <h2>{{ __('dashboard.postflop_training_title') }}</h2>
                <p>{{ __('dashboard.postflop_training_text') }}</p>
                <strong>{{ __('dashboard.enter_arrow') }}</strong>
            </a>

            @if($turnUnlocked)

                <a href="{{ route('postflop-turn.index') }}"
                class="dashboard-card table-card active">

                    <span>{{ __('dashboard.new_training') }}</span>
                    <h2>{{ __('dashboard.postflop_turn_title') }}</h2>

                    <p>{{ __('dashboard.postflop_turn_text') }}</p>

                    <strong>{{ __('dashboard.enter_arrow') }}</strong>

                </a>

                @else

                <article class="dashboard-card table-card">

                    <span>{{ __('dashboard.locked') }}</span>
                    <h2>{{ __('dashboard.postflop_turn_title') }}</h2>

                    <p>{{ __('dashboard.unlock_turn_text') }}</p>

                    <strong>🔒</strong>

                </article>

                @endif

            @if($riverUnlocked)

                <a href="{{ route('postflop-river.index') }}"
                class="dashboard-card table-card active">

                    <span>{{ __('dashboard.new_training') }}</span>
                    <h2>{{ __('dashboard.postflop_river_title') }}</h2>

                    <p>{{ __('dashboard.postflop_river_text') }}</p>

                    <strong>{{ __('dashboard.enter_arrow') }}</strong>

                </a>

                @else

                <article class="dashboard-card table-card">

                    <span>{{ __('dashboard.locked') }}</span>
                    <h2>{{ __('dashboard.postflop_river_title') }}</h2>

                    <p>{{ __('dashboard.unlock_river_text') }}</p>

                    <strong>🔒</strong>

                </article>

                @endif

                @if($masteryUnlocked ?? false)

                    <a href="{{ route('mastery-training.index') }}"
                    class="dashboard-card table-card active">

                        <span>{{ __('dashboard.advanced_training') }}</span>

                        <h2>{{ __('dashboard.mastery') }}</h2>

                        <p>{{ __('dashboard.mastery_text') }}</p>

                        <strong>{{ __('dashboard.enter_arrow') }}</strong>

                    </a>

                @else

                    <article class="dashboard-card table-card">

                        <span>{{ __('dashboard.locked') }}</span>

                        <h2>{{ __('dashboard.mastery') }}</h2>

                        <p>{{ __('dashboard.unlock_mastery_text') }}</p>

                        <strong>🔒</strong>

                    </article>

                @endif

                @if($certificationUnlocked ?? false)

                    <a href="{{ route('certification.index') }}"
                    class="dashboard-card table-card active">

                        <span>{{ __('dashboard.final_exam') }}</span>

                        <h2>{{ __('dashboard.certification') }}</h2>

                        <p>{{ __('dashboard.certification_text') }}</p>

                        <strong>{{ __('dashboard.enter_arrow') }}</strong>

                    </a>

                @else

                    <article class="dashboard-card table-card">

                        <span>{{ __('dashboard.locked') }}</span>

                        <h2>{{ __('dashboard.certification') }}</h2>

                        <p>{{ __('dashboard.unlock_certification_text') }}</p>

                        <strong>🔒</strong>

                    </article>

                @endif

            <article class="dashboard-card table-card">
                <span>{{ __('dashboard.latest_results') }}</span>
                    <h2>{{ __('dashboard.recent_activity') }}</h2>
                    @forelse ($recentResults as $result)
                        <div class="metric-row">
                            <span>{{ $result->module_label }} · {{ $result->selected_action }}</span>
                            <strong class="grade-pill grade-{{ $result->grade }}">{{ strtoupper($result->grade) }}</strong>
                        </div>
                    @empty
                        <p>{{ __('dashboard.no_spots_answered_yet') }}</p>
                    @endforelse
                </article>
        </section>
    </main>
</x-app-layout>

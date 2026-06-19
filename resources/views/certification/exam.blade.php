<x-app-layout>
    <link href="{{ asset('assets/css/certification-exam.css') }}" rel="stylesheet">

    <main class="cert-page">
        <section class="cert-topbar">
            <div class="cert-topbar-left">
                <span class="cert-kicker">Certification ApexCash</span>
                <h1>Pregunta {{ $questionNumber }} de {{ $totalQuestions }}</h1>
            </div>

            <div class="cert-timer-box">
                <span>Tiempo restante</span>
                <strong id="timer" data-seconds="{{ $secondsRemaining }}">--:--:--</strong>
                <div class="cert-timer-track">
                    <div id="timerBar" class="cert-timer-bar"></div>
                </div>
            </div>
        </section>

        <section class="cert-layout">
            <div class="cert-table-card">
                <div class="cert-table">
                    <div class="cert-felt">
                        <div class="cert-board-zone">
                            <span>{{ strtoupper($question['street'] ?? $question['block']) }}</span>

                            @if(!empty($question['board_cards']))
                                <div class="cert-board-cards">
                                    @foreach($question['board_cards'] as $card)
                                        @php $suit = substr($card, -1); $rank = substr($card, 0, -1); @endphp
                                        <div class="cert-card {{ in_array($suit, ['h','d']) ? 'red' : '' }}">
                                            {{ $rank }}{{ ['h'=>'♥','d'=>'♦','c'=>'♣','s'=>'♠'][$suit] ?? $suit }}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <strong>SPOT PREFLOP</strong>
                            @endif

                            <strong>Pot: {{ $question['pot_bb'] }} BB</strong>
                            @if(!empty($question['spr']))
                                <small>SPR: {{ $question['spr'] }}</small>
                            @endif
                        </div>

                        @foreach(['UTG','HJ','CO','BTN','SB','BB'] as $position)
                            @php
                                $player = collect($question['table_players'] ?? [])->firstWhere('position', $position) ?? [];
                            @endphp
                            <div class="cert-seat cert-seat-{{ strtolower($position) }} {{ !empty($player['is_hero']) ? 'hero' : '' }} {{ !empty($player['is_villain']) ? 'villain' : '' }}">
                                <span class="pos">{{ $position }}</span>
                                <strong>{{ $player['name'] ?? $position }}</strong>
                                <small>{{ $player['stack_bb'] ?? ($question['effective_stack_bb'] ?? 100) }} BB</small>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="cert-hero-strip">
                    <span>Hero {{ $question['hero_position'] }}</span>
                    <div class="cert-hero-cards">
                        @foreach($question['hero_cards'] as $card)
                            @php $suit = substr($card, -1); $rank = substr($card, 0, -1); @endphp
                            <div class="cert-card {{ in_array($suit, ['h','d']) ? 'red' : '' }}">
                                {{ $rank }}{{ ['h'=>'♥','d'=>'♦','c'=>'♣','s'=>'♠'][$suit] ?? $suit }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="cert-panel">
                <div class="cert-box cert-question-box">
                    <span class="cert-module">{{ $question['block_label'] }} · {{ $question['module_label'] }}</span>
                    <h2>{{ $question['title'] }}</h2>
                    <p>Selecciona una respuesta. Puedes cambiarla antes de continuar.</p>
                </div>

                <div class="cert-box cert-actions-box">
                    <h3>Acción previa</h3>
                    <ol>
                        @foreach($question['actions'] as $action)
                            <li>{{ $action }}</li>
                        @endforeach
                    </ol>
                </div>

                <form method="POST" action="{{ route('certification.answer', $attempt) }}" id="answerForm" class="cert-answer-form">
                    @csrf

                    <div class="cert-answer-grid">
                        @foreach($question['options'] as $option)
                            <label class="cert-answer-option">
                                <input type="radio" name="answer" value="{{ $option }}">
                                <span>{{ strtoupper(str_replace('_', ' ', $option)) }}</span>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit" id="nextButton" disabled class="cert-next-button">
                        {{ $questionNumber >= $totalQuestions ? 'Finalizar y enviar examen' : 'Siguiente pregunta' }}
                    </button>
                </form>

                <div class="cert-box cert-note-box">
                    No hay feedback durante el examen. No puedes volver atrás. La respuesta queda bloqueada solo al pulsar el botón de continuar.
                </div>
            </aside>
        </section>
    </main>

    <form method="POST" action="{{ route('certification.finish', $attempt) }}" id="timeoutForm" hidden>@csrf</form>

    <script>
        const timer = document.getElementById('timer');
        const timerBar = document.getElementById('timerBar');
        const timeoutForm = document.getElementById('timeoutForm');
        const totalSeconds = 90 * 60;
        let remaining = Math.floor(Number(timer.dataset.seconds || 0));

        function formatTime(seconds) {
            seconds = Math.max(0, Math.floor(seconds));
            const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
            const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            return `${h}:${m}:${s}`;
        }

        function renderTimer() {
            timer.textContent = formatTime(remaining);
            timerBar.style.width = `${Math.max(0, Math.min(100, (remaining / totalSeconds) * 100))}%`;

            if (remaining <= 0) {
                timeoutForm.submit();
                return;
            }

            remaining -= 1;
            setTimeout(renderTimer, 1000);
        }

        document.querySelectorAll('.cert-answer-option input').forEach((input) => {
            input.addEventListener('change', () => {
                document.querySelectorAll('.cert-answer-option').forEach((label) => {
                    label.classList.remove('selected');
                });

                input.closest('.cert-answer-option').classList.add('selected');
                document.getElementById('nextButton').disabled = false;
            });
        });

        renderTimer();
    </script>
</x-app-layout>

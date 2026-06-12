(() => {
    const state = {
        spot: window.ApexPostflopTraining?.initialSpot ?? null,
        summary: window.ApexPostflopTraining?.initialSummary ?? {},
        leaks: window.ApexPostflopTraining?.initialLeaks ?? [],
        currentModule: window.ApexPostflopTraining?.initialModule ?? '',
        locked: false,
    };

    const config = window.ApexPostflopTraining ?? {};

    const $ = (id) => document.getElementById(id);

    const els = {
        spotModule: $('spotModule'),
        spotTitle: $('spotTitle'),
        spotMeta: $('spotMeta'),
        boardCards: $('boardCards'),
        heroCards: $('heroCards'),
        spotPot: $('spotPot'),
        spotSpr: $('spotSpr'),
        heroPosition: $('heroPosition'),
        villainPosition: $('villainPosition'),
        boardTexture: $('boardTexture'),
        rangeAdvantage: $('rangeAdvantage'),
        nutAdvantage: $('nutAdvantage'),
        spotActions: $('spotActions'),
        decisionButtons: $('decisionButtons'),
        nextSpotBtn: $('nextSpotBtn'),
        decisionResultBox: $('decisionResultBox'),
        feedbackBox: $('feedbackBox'),
        gradeBox: $('gradeBox'),
        frequencyBox: $('frequencyBox'),
        evBox: $('evBox'),
        gtoInsightBox: $('gtoInsightBox'),
        lowStakesInsightBox: $('lowStakesInsightBox'),
        summaryTotal: $('summaryTotal'),
        summaryCorrect: $('summaryCorrect'),
        summaryWrong: $('summaryWrong'),
        summaryAccuracy: $('summaryAccuracy'),
        leaksList: $('leaksList'),
        moduleFilter: $('moduleFilter'),
        textureBox: $('textureBox'),
    };

    const redSuits = ['h', 'd', '♥', '♦'];

    function cardHtml(card, className = 'card') {
        const value = String(card ?? '--');
        const suit = value.slice(-1).toLowerCase();
        const isRed = redSuits.includes(suit);
        const display = value
            .replace('s', '♠')
            .replace('h', '♥')
            .replace('d', '♦')
            .replace('c', '♣');

        return `<div class="${className}${isRed ? ' red' : ''}">${display}</div>`;
    }

    function actionLabel(action) {
        return {
            CHECK: 'Check',
            BET_33: 'Bet 33%',
            BET_66: 'Bet 66%',
            FOLD: 'Fold',
            CALL: 'Call',
            RAISE: 'Raise',
        }[action] ?? action;
    }

    function buttonClass(action) {
        if (action === 'FOLD') return 'decision-btn danger';
        if (action === 'CALL' || action === 'CHECK') return 'decision-btn secondary';
        if (action === 'RAISE') return 'decision-btn blue';
        return 'decision-btn';
    }

    function renderSpot() {
        const spot = state.spot;
        if (!spot) return;

        state.locked = false;

        els.textureBox.hidden = true;

        els.spotModule.textContent = spot.module_label ?? '--';
        els.spotTitle.textContent = spot.title ?? 'Spot postflop';
        els.spotMeta.textContent = `${spot.street?.toUpperCase() ?? 'FLOP'} · ${spot.hero_position} vs ${spot.villain_position} · ${spot.difficulty ?? 'Postflop V1'} · confianza ${spot.confidence ?? 0}%`;

        els.boardCards.innerHTML = (spot.board_cards ?? []).map(card => cardHtml(card, 'board-card')).join('');
        els.heroCards.innerHTML = (spot.hero_cards ?? []).map(card => cardHtml(card, 'card')).join('');
        els.spotPot.textContent = `Pot: ${spot.pot_bb ?? '--'} BB`;
        els.spotSpr.textContent = `SPR: ${spot.spr ?? '--'}`;
        els.heroPosition.textContent = spot.hero_position ?? '--';
        els.villainPosition.textContent = spot.villain_position ?? '--';

        els.boardTexture.textContent = spot.board_texture ?? '--';
        els.rangeAdvantage.textContent = spot.range_advantage ?? '--';
        els.nutAdvantage.textContent = spot.nut_advantage ?? '--';
        
        renderPlayers(spot.table_players ?? []);
        renderActions(spot.actions ?? []);
        renderDecisionButtons(spot.options ?? []);
        hideInsights();
        hideResult();

        els.decisionButtons.style.display = 'grid';
        
        renderSummary(state.summary);
        renderLeaks(state.leaks);
        renderModuleFilter();
    }

    function renderPlayers(players) {
        document.querySelectorAll('.seat').forEach(seat => {
            seat.classList.remove('hero', 'villain');
            const position = seat.dataset.position;
            const player = players.find(p => p.position === position);

            if (!player) {
                seat.innerHTML = '';
                return;
            }

            if (player.is_hero) seat.classList.add('hero');
            if (player.is_villain) seat.classList.add('villain');

            seat.innerHTML = `
                <div class="pos">${player.position}</div>
                <div class="name">${player.name ?? player.position}</div>
                <div class="stack">${player.stack_bb ?? 100} BB</div>
            `;
        });
    }

    function renderActions(actions) {
        const stackLine = state.spot?.effective_stack_bb
            ? `<li>Stack efectivo: ${state.spot.effective_stack_bb} BB</li>`
            : '';
        
        els.spotActions.innerHTML = actions.map(action => `<li>${action}</li>`).join('');
    }

    function renderDecisionButtons(options) {
        els.decisionButtons.innerHTML = options.map(action => `
            <button type="button" class="${buttonClass(action)}" data-answer="${action}">
                ${actionLabel(action)}
            </button>
        `).join('');

        els.decisionButtons.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', () => answer(button.dataset.answer));
        });
    }

    function renderInsights(insights) {
        if (insights.gto) {
            els.gtoInsightBox.hidden = false;
            els.gtoInsightBox.innerHTML = `<strong>GTO simplificado</strong><br>${insights.gto}`;
        } else {
            els.gtoInsightBox.hidden = true;
        }

        if (insights.low_stakes) {
            els.lowStakesInsightBox.hidden = false;
            els.lowStakesInsightBox.innerHTML = `<strong>Límites bajos NL2-NL10</strong><br>${insights.low_stakes}`;
        } else {
            els.lowStakesInsightBox.hidden = true;
        }
    }

    function renderSummary(summary) {
        els.summaryTotal.textContent = summary.total ?? 0;
        els.summaryCorrect.textContent = summary.correct ?? 0;
        els.summaryWrong.textContent = summary.wrong ?? 0;
        els.summaryAccuracy.textContent = `${summary.accuracy ?? 0}%`;
    }

    function renderLeaks(leaks) {
        if (!Array.isArray(leaks) || leaks.length === 0) {
            els.leaksList.innerHTML = '<p class="spot-meta">Aún no hay suficientes manos postflop para detectar leaks.</p>';
            return;
        }

        els.leaksList.innerHTML = leaks.map(leak => `
            <div class="leak-row">
                <span>${leak.module_label ?? leak.module}</span>
                <strong>${leak.accuracy ?? 0}%</strong>
            </div>
        `).join('');
    }

    function renderModuleFilter() {
        if (!els.moduleFilter) return;

        els.moduleFilter.querySelectorAll('button').forEach(button => {
            const module = button.dataset.module ?? '';
            button.classList.toggle('is-active', module === (state.currentModule ?? ''));
        });
    }

    function hideResult() {
       
        if (els.textureBox) {
            els.textureBox.hidden = true;
        }

        els.decisionResultBox.hidden = true;
        [els.feedbackBox, els.gradeBox, els.frequencyBox, els.evBox].forEach(box => {
            box.hidden = true;
            box.innerHTML = '';
            box.classList.remove('correct', 'wrong');
        });
    }

    async function answer(selectedAnswer) {
        if (state.locked) return;
        state.locked = true;

        try {
            const response = await fetch(config.answerUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': config.csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ answer: selectedAnswer }),
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message ?? 'No se pudo evaluar la respuesta.');
            }

            state.summary = data.summary ?? state.summary;
            state.leaks = data.leaks ?? state.leaks;
            renderResult(data);
            renderSummary(state.summary);
            renderLeaks(state.leaks);
        } catch (error) {
            alert(error.message ?? 'Error inesperado evaluando el spot.');
            state.locked = false;
        }
    }

    function renderResult(data) {
        els.decisionButtons.style.display = 'none';
        
        renderInsights(state.spot?.insights ?? {});

        els.decisionResultBox.hidden = false;

        els.textureBox.hidden = false;

        els.feedbackBox.hidden = false;
        els.feedbackBox.classList.add(data.correct ? 'correct' : 'wrong');
        els.feedbackBox.innerHTML = `
            <strong>${data.title ?? 'Resultado'}</strong><br>
            Elegiste <strong>${actionLabel(data.selected_action)}</strong>. Mejor acción: <strong>${actionLabel(data.correct_action)}</strong>.<br>
            ${data.explanation ?? ''}
        `;

        els.gradeBox.hidden = false;
        els.gradeBox.innerHTML = `<span>Grado</span><strong>${String(data.grade ?? '--').toUpperCase()}</strong>`;

        els.frequencyBox.hidden = false;
        els.frequencyBox.innerHTML = `<span>Frecuencia sugerida</span><strong>${data.frequency ?? '--'}%</strong>`;

        els.evBox.hidden = false;
        els.evBox.innerHTML = `<span>EV relativo</span><strong>${data.ev_score ?? 0}/100 · +${data.xp_earned ?? 0} XP</strong>`;
    }

    function hideInsights() {
        [els.gtoInsightBox, els.lowStakesInsightBox].forEach(box => {
            if (!box) return;

            box.hidden = true;
            box.innerHTML = '';
        });
    }

    async function nextSpot() {
        hideResult();

        const params = new URLSearchParams();
        if (state.currentModule) params.set('module', state.currentModule);

        try {
            const response = await fetch(`${config.nextUrl}?${params.toString()}`, {
                headers: { 'Accept': 'application/json' },
            });
            const data = await response.json();

            if (!data.success) {
                throw new Error('No se pudo cargar el siguiente spot.');
            }

            state.spot = data.spot;
            state.summary = data.summary ?? state.summary;
            state.leaks = data.leaks ?? state.leaks;
            renderSpot();
        } catch (error) {
            alert(error.message ?? 'Error cargando spot.');
        }
    }

    els.nextSpotBtn?.addEventListener('click', nextSpot);

    els.moduleFilter?.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', () => {
            state.currentModule = button.dataset.module ?? '';
            nextSpot();
        });
    });

    renderSpot();
})();

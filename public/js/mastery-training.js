(() => {
    const state = {
        spot: window.ApexMasteryTraining?.initialSpot ?? null,
        summary: window.ApexMasteryTraining?.initialSummary ?? {},
        leaks: window.ApexMasteryTraining?.initialLeaks ?? [],
        currentModule: window.ApexMasteryTraining?.initialModule ?? '',
        locked: false,
    };

    const config = window.ApexMasteryTraining ?? {};
    const i18n = config.i18n ?? {};
    const t = (key, fallback = '') => i18n[key] ?? fallback;
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
        effectiveStack: $('effectiveStack'),
        textureBox: $('textureBox'),
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
        boardStreetLabel: $('boardStreetLabel'),
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
            CHECK: t('action_check', 'Check'),
            BET_25: t('action_bet_25', 'Bet 25%'),
            BET_33: t('action_bet_33', 'Bet 33%'),
            BET_50: t('action_bet_50', 'Bet 50%'),
            BET_66: t('action_bet_66', 'Bet 66%'),
            BET_75: t('action_bet_75', 'Bet 75%'),
            BET_100: t('action_bet_pot', 'Bet Pot'),
            BET_125: t('action_overbet_125', 'Overbet 125%'),
            BET_150: t('action_overbet_150', 'Overbet 150%'),
            FOLD: t('action_fold', 'Fold'),
            CALL: t('action_call', 'Call'),
            RAISE: t('action_raise', 'Raise'),
            RAISE_2_5X: t('action_raise_2_5x', 'Raise 2.5x'),
            RAISE_3X: t('action_raise_3x', 'Raise 3x'),
            JAM: t('action_all_in', 'All-in'),
            SHOVE: t('action_all_in', 'All-in'),
        }[action] ?? action;
    }

    function buttonClass(action) {
        if (action === 'FOLD' || action === 'JAM' || action === 'SHOVE') return 'decision-btn danger';
        if (action === 'CALL' || action === 'CHECK') return 'decision-btn secondary';
        if (action === 'RAISE' || action === 'RAISE_2_5X' || action === 'RAISE_3X') return 'decision-btn blue';
        return 'decision-btn';
    }

    function renderSpot() {
        const spot = state.spot;
        if (!spot) return;

        state.locked = false;

        const street = String(spot.street ?? 'river').toLowerCase();

        const streetLabel = {
            flop: 'FLOP',
            turn: 'TURN',
            river: 'RIVER',
            preflop: 'PREFLOP',
        }[street] ?? street.toUpperCase();

        if (els.boardStreetLabel) {
            els.boardStreetLabel.textContent = street === 'preflop'
                ? t('no_board_preflop', 'SIN BOARD · PREFLOP')
                : `${t('board', 'BOARD')} · ${streetLabel}`;
        }

        els.spotModule.textContent = spot.module_label ?? '--';
        els.spotTitle.textContent = spot.title ?? t('spot_mastery', 'Spot mastery');
        els.spotMeta.textContent = `${streetLabel} · ${spot.hero_position} vs ${spot.villain_position} · ${spot.difficulty ?? 'Mastery'} · ${t('confidence', 'confianza')} ${spot.confidence ?? 0}%`;

        const boardCards = spot.board_cards ?? [];

        els.boardCards.innerHTML = boardCards.length
            ? boardCards.map(card => cardHtml(card, 'board-card')).join('')
            : `<div class="spot-meta">${t('preflop_no_board', 'Preflop / Sin board')}</div>`;
            
        els.heroCards.innerHTML = (spot.hero_cards ?? []).map(card => cardHtml(card, 'card')).join('');
        els.spotPot.textContent = `${t('pot', 'Pot')}: ${spot.pot_bb ?? '--'} BB`;
        els.spotSpr.textContent = `${t('spr', 'SPR')}: ${spot.spr ?? '--'}`;
        els.heroPosition.textContent = spot.hero_position ?? '--';
        els.villainPosition.textContent = spot.villain_position ?? '--';

        els.boardTexture.textContent = spot.board_texture ?? '--';
        els.rangeAdvantage.textContent = spot.range_advantage ?? '--';
        els.nutAdvantage.textContent = spot.nut_advantage ?? '--';
        els.effectiveStack.textContent = spot.effective_stack_bb ? `${spot.effective_stack_bb} BB` : '--';

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
            els.gtoInsightBox.innerHTML = `<strong>${t('gto_simplified', 'GTO simplificado')}</strong><br>${insights.gto}`;
        } else {
            els.gtoInsightBox.hidden = true;
        }

        if (insights.low_stakes) {
            els.lowStakesInsightBox.hidden = false;
            els.lowStakesInsightBox.innerHTML = `<strong>${t('low_stakes', 'Límites bajos NL2-NL10')}</strong><br>${insights.low_stakes}`;
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
            els.leaksList.innerHTML = `<p class="spot-meta">${t('no_leaks_yet', 'Aún no hay suficientes manos de mastery para detectar leaks.')}</p>`;
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
        if (els.textureBox) els.textureBox.hidden = true;

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
                throw new Error(data.message ?? t('cannot_evaluate', 'No se pudo evaluar la respuesta.'));
            }

            state.summary = data.summary ?? state.summary;
            state.leaks = data.leaks ?? state.leaks;
            renderResult(data);
            renderSummary(state.summary);
            renderLeaks(state.leaks);
        } catch (error) {
            alert(error.message ?? t('unexpected_evaluating', 'Error inesperado evaluando el spot.'));
            state.locked = false;
        }
    }

    function renderResult(data) {
        els.decisionButtons.style.display = 'none';

        renderInsights(state.spot?.insights ?? {});

        if (els.textureBox) els.textureBox.hidden = false;
        els.decisionResultBox.hidden = false;

        els.feedbackBox.hidden = false;
        els.feedbackBox.classList.add(data.correct ? 'correct' : 'wrong');
        els.feedbackBox.innerHTML = `
            <strong>${data.title ?? t('result', 'Resultado')}</strong><br>
            ${t('you_chose', 'Elegiste')} <strong>${actionLabel(data.selected_action)}</strong>. ${t('best_action', 'Mejor acción')}: <strong>${actionLabel(data.correct_action)}</strong>.<br>
            ${data.explanation ?? ''}
        `;

        els.gradeBox.hidden = false;
        els.gradeBox.innerHTML = `<span>${t('grade', 'Grado')}</span><strong>${String(data.grade ?? '--').toUpperCase()}</strong>`;

        els.frequencyBox.hidden = false;
        els.frequencyBox.innerHTML = `<span>${t('suggested_frequency', 'Frecuencia sugerida')}</span><strong>${data.frequency ?? '--'}%</strong>`;

        els.evBox.hidden = false;
        els.evBox.innerHTML = `<span>${t('relative_ev', 'EV relativo')}</span><strong>${data.ev_score ?? 0}/100 · +${data.xp_earned ?? 0} ${t('xp', 'XP')}</strong>`;
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
                throw new Error(t('cannot_load_next', 'No se pudo cargar el siguiente spot.'));
            }

            state.spot = data.spot;
            state.summary = data.summary ?? state.summary;
            state.leaks = data.leaks ?? state.leaks;
            renderSpot();
        } catch (error) {
            alert(error.message ?? t('loading_error', 'Error cargando spot.'));
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

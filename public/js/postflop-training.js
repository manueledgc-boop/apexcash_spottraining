(() => {
    const state = {
        spot: window.ApexPostflopTraining?.initialSpot ?? null,
        summary: window.ApexPostflopTraining?.initialSummary ?? {},
        leaks: window.ApexPostflopTraining?.initialLeaks ?? [],
        currentModule: window.ApexPostflopTraining?.initialModule ?? '',
        locked: false,
    };

    const config = window.ApexPostflopTraining ?? {};
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
        return (i18n.actions ?? {})[action] ?? {
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
        els.spotTitle.textContent = spot.title ?? t('default_title', 'Postflop spot');
        els.spotMeta.textContent = `${spot.street?.toUpperCase() ?? 'FLOP'} · ${spot.hero_position} vs ${spot.villain_position} · ${spot.difficulty ?? t('default_difficulty', 'Postflop V1')} · ${t('confidence', 'confidence')} ${spot.confidence ?? 0}%`;

        els.boardCards.innerHTML = (spot.board_cards ?? []).map(card => cardHtml(card, 'board-card')).join('');
        els.heroCards.innerHTML = (spot.hero_cards ?? []).map(card => cardHtml(card, 'card')).join('');
        els.spotPot.textContent = `${t('pot', 'Pot')}: ${spot.pot_bb ?? '--'} BB`;
        els.spotSpr.textContent = `${t('spr', 'SPR')}: ${spot.spr ?? '--'}`;
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
            ? `<li>${t('effective_stack', 'Effective stack')}: ${state.spot.effective_stack_bb} BB</li>`
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
            els.gtoInsightBox.innerHTML = `<strong>${t('gto_simplified', 'Simplified GTO')}</strong><br>${insights.gto}`;
        } else {
            els.gtoInsightBox.hidden = true;
        }

        if (insights.low_stakes) {
            els.lowStakesInsightBox.hidden = false;
            els.lowStakesInsightBox.innerHTML = `<strong>${t('low_stakes', 'Low stakes NL2-NL10')}</strong><br>${insights.low_stakes}`;
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
            els.leaksList.innerHTML = `<p class="spot-meta">${t('no_leaks', 'Not enough postflop hands yet to detect leaks.')}</p>`;
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

    function showFreeLimit(message) {
        state.spot = null;
        state.locked = true;

        if (els.spotModule) els.spotModule.textContent = 'Free';
        if (els.spotTitle) els.spotTitle.textContent = 'Límite gratuito alcanzado';
        if (els.spotMeta) els.spotMeta.textContent = '';
        if (els.boardCards) els.boardCards.innerHTML = '';
        if (els.heroCards) els.heroCards.innerHTML = '';
        if (els.spotPot) els.spotPot.textContent = '';
        if (els.spotSpr) els.spotSpr.textContent = '';
        if (els.spotActions) els.spotActions.innerHTML = '';

        document.querySelectorAll('.seat').forEach((seat) => {
            seat.innerHTML = '';
            seat.classList.remove('hero', 'villain');
        });

        if (els.decisionButtons) {
            els.decisionButtons.hidden = true;
            els.decisionButtons.style.display = 'none';
            els.decisionButtons.innerHTML = '';
        }

        if (els.nextSpotBtn) {
            els.nextSpotBtn.hidden = true;
            els.nextSpotBtn.style.display = 'none';
            els.nextSpotBtn.disabled = true;
        }

        if (els.textureBox) {
            els.textureBox.hidden = true;
        }

        if (els.decisionResultBox) {
            els.decisionResultBox.hidden = false;
        }

        if (els.feedbackBox) {
            els.feedbackBox.hidden = false;
            els.feedbackBox.className = 'feedback wrong';
            els.feedbackBox.innerHTML = `
                <strong>Acceso gratuito completado</strong><br>
                <p>${message || 'Has completado el límite gratuito de Flop. Actualiza a Premium para continuar.'}</p>
                <a href="/premium" class="upgrade-premium-btn">
                    Actualizar a Premium
                </a>
            `;
        }
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

            if (data.success === false && data.code === 'FREE_LIMIT_REACHED') {
                showFreeLimit(data.message);
                return;
            }

            if (!data.success) {
                throw new Error(data.message ?? t('answer_error', 'Could not evaluate the answer.'));
            }

            state.summary = data.summary ?? state.summary;
            state.leaks = data.leaks ?? state.leaks;
            renderResult(data);
            renderSummary(state.summary);
            renderLeaks(state.leaks);
        } catch (error) {
            alert(error.message ?? t('unexpected_answer_error', 'Unexpected error evaluating the spot.'));
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
            <strong>${data.title ?? t('result', 'Result')}</strong><br>
            ${t('you_chose', 'You chose')} <strong>${actionLabel(data.selected_action)}</strong>. ${t('best_action', 'Best action')}: <strong>${actionLabel(data.correct_action)}</strong>.<br>
            ${data.explanation ?? ''}
        `;

        els.gradeBox.hidden = false;
        els.gradeBox.innerHTML = `<span>${t('grade', 'Grade')}</span><strong>${String(data.grade ?? '--').toUpperCase()}</strong>`;

        els.frequencyBox.hidden = false;
        els.frequencyBox.innerHTML = `<span>${t('suggested_frequency', 'Suggested frequency')}</span><strong>${data.frequency ?? '--'}%</strong>`;

        els.evBox.hidden = false;
        els.evBox.innerHTML = `<span>${t('relative_ev', 'Relative EV')}</span><strong>${data.ev_score ?? 0}/100 · +${data.xp_earned ?? 0} XP</strong>`;
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

            if (data.success === false && data.code === 'FREE_LIMIT_REACHED') {
                showFreeLimit(data.message);
                return;
            }

            if (!data.success) {
                throw new Error(t('next_error', 'Could not load the next spot.'));
            }

            state.spot = data.spot;
            state.summary = data.summary ?? state.summary;
            state.leaks = data.leaks ?? state.leaks;
            renderSpot();
        } catch (error) {
            alert(error.message ?? t('unexpected_next_error', 'Error loading spot.'));
        }
    }

    els.nextSpotBtn?.addEventListener('click', nextSpot);

    els.moduleFilter?.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', () => {
            state.currentModule = button.dataset.module ?? '';
            nextSpot();
        });
    });

    if (config.freeLimitReached) {
        showFreeLimit(config.freeLimitMessage);
    } else {
        renderSpot();
    }
})();

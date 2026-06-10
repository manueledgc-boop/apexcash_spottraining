(function () {
    const urlParams = new URLSearchParams(window.location.search);

    const state = {
        spot: window.ApexSpotTraining.initialSpot,
        summary: window.ApexSpotTraining.initialSummary,
        currentModule: window.ApexSpotTraining.initialModule || null,
        currentMode: window.ApexSpotTraining.initialMode || 'normal',
        currentConcept: urlParams.get('concept') || null,
        leaks: window.ApexSpotTraining.initialLeaks || [],
        lifetime: window.ApexSpotTraining.lifetime || {},
    };

    const els = {
        module: document.getElementById('spotModule'),
        title: document.getElementById('spotTitle'),
        meta: document.getElementById('spotMeta'),
        pot: document.getElementById('spotPot'),
        actions: document.getElementById('spotActions'),
        buttons: document.getElementById('decisionButtons'),
        feedback: document.getElementById('feedbackBox'),
        gradeBox: document.getElementById('gradeBox'),
        frequencyBox: document.getElementById('frequencyBox'),
        evBox: document.getElementById('evBox'),
        next: document.getElementById('nextSpotBtn'),
        heroCards: document.getElementById('heroCards'),
        summaryTotal: document.getElementById('summaryTotal'),
        summaryCorrect: document.getElementById('summaryCorrect'),
        summaryWrong: document.getElementById('summaryWrong'),
        summaryAccuracy: document.getElementById('summaryAccuracy'),
        leaksList: document.getElementById('leaksList'),
        practiceLeakBtn: document.getElementById('practiceLeakBtn'),
        moduleFilter: document.getElementById('moduleFilter'),
        decisionResultBox: document.getElementById('decisionResultBox'),
        lowStakesInsightBox: document.getElementById('lowStakesInsightBox'),
    };

    function cardHtml(card) {
        const suit = card.slice(-1);
        const rank = card.slice(0, -1);
        const symbol = { h: '♥', d: '♦', c: '♣', s: '♠' }[suit] || suit;
        const red = suit === 'h' || suit === 'd';
        return `<div class="card ${red ? 'red' : ''}">${rank}${symbol}</div>`;
    }

    function renderSeats(spot) {
        document.querySelectorAll('.seat').forEach((seat) => {
            const position = seat.dataset.position;
            const player = spot.table_players.find((item) => item.position === position);
            seat.classList.toggle('hero', Boolean(player?.is_hero));
            seat.classList.toggle('villain', Boolean(player?.is_villain));
            seat.innerHTML = `
                <div class="pos">${position}</div>
                <div class="name">${player?.name || position}</div>
                <div class="stack">${player?.stack_bb || 100} BB</div>
            `;
        });
    }

    function renderSummary(summary) {
        summary = summary || {};
        els.summaryTotal.textContent = summary.total ?? 0;
        els.summaryCorrect.textContent = summary.correct ?? 0;
        els.summaryWrong.textContent = summary.wrong ?? 0;
        els.summaryAccuracy.textContent = `${summary.accuracy ?? 0}%`;
    }

    function clearFeedback() {
        els.feedback.hidden = true;
        els.feedback.style.display = 'none';
        els.feedback.className = 'feedback';
        els.feedback.innerHTML = '';

        [els.gradeBox, els.frequencyBox, els.evBox, els.lowStakesInsightBox].forEach((box) => {
            if (!box) return;
            box.hidden = true;
            box.style.display = 'none';
            box.innerHTML = '';
        });

        if (els.decisionResultBox) {
            els.decisionResultBox.hidden = true;
            els.decisionResultBox.style.display = 'none';
        }

        if (els.buttons) {
            els.buttons.hidden = false;
            els.buttons.style.display = '';
        }
    }

    function renderSpot() {
        const spot = state.spot;
        if (!spot) return;

        els.module.textContent = spot.module_label;
        els.title.textContent = spot.title;
        els.meta.textContent = `Hero ${spot.hero_position} · Villano ${spot.villain_position || 'sin villano directo'} · Stacks ${spot.stacks.hero_bb} BB`;
        els.pot.textContent = `Pot: ${spot.pot_bb} BB`;
        els.actions.innerHTML = spot.actions.map((action) => `<li>${action}</li>`).join('');
        els.heroCards.innerHTML = spot.hero_cards.map(cardHtml).join('');
        clearFeedback();
        els.buttons.innerHTML = spot.options.map((option) => {
            const cls = option === 'FOLD' ? 'danger' : (option === 'CALL' ? 'secondary' : '');
            return `<button type="button" class="decision-btn ${cls}" data-answer="${option}">${option}</button>`;
        }).join('');

        els.buttons.querySelectorAll('button').forEach((btn) => {
            btn.disabled = false;
        });

        renderSeats(spot);
        renderSummary(state.summary || {});
        renderLeaks(state.leaks || []);
    }

    function renderDecisionDetails(data) {
        if (els.gradeBox) {
            els.gradeBox.removeAttribute('hidden');
            els.gradeBox.style.display = 'block';
            els.gradeBox.className = `grade-box grade-${data.grade || 'unknown'}`;
            els.gradeBox.innerHTML = `
                <span>Calidad de decisión</span>
                <strong>${String(data.grade || 'unknown').toUpperCase()}</strong>
            `;
        }

        if (els.frequencyBox) {
            els.frequencyBox.removeAttribute('hidden');
            els.frequencyBox.style.display = 'block';
            els.frequencyBox.innerHTML = `
                <span>Frecuencia GTO simplificada</span>
                <strong>${data.selected_action || '-'}: ${data.frequency ?? '-'}%</strong>
            `;
        }

        if (els.evBox) {
            els.evBox.removeAttribute('hidden');
            els.evBox.style.display = 'block';
            els.evBox.innerHTML = `
                <span>EV relativo</span>
                <strong>${data.ev_score ?? 0}/100</strong>
            `;
        }
    }

    function renderLeaks(leaks) {
        if (!els.leaksList) return;
        els.leaksList.innerHTML = '';

        if (!Array.isArray(leaks) || leaks.length === 0) {
            els.leaksList.innerHTML = `<p class="spot-meta">Aún no hay datos suficientes.</p>`;
            return;
        }

        leaks.forEach((leak) => {
            const row = document.createElement('div');
            row.className = 'leak-row';
            row.innerHTML = `
                <span>${leak.module_label}</span>
                <strong>${leak.accuracy}%</strong>
            `;
            els.leaksList.appendChild(row);
        });
    }

    async function answerSpot(answer) {
        const response = await fetch(window.ApexSpotTraining.answerUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.ApexSpotTraining.csrf,
            },
            body: JSON.stringify({ answer }),
        });

        const data = await response.json();

        if (!data.success) {
            if (els.decisionResultBox) {
                els.decisionResultBox.removeAttribute('hidden');
                els.decisionResultBox.style.display = 'block';
            }

            els.feedback.removeAttribute('hidden');
            els.feedback.style.display = 'block';
            els.feedback.className = 'feedback wrong';
            els.feedback.textContent = data.message || 'No se pudo evaluar el spot.';
            return;
        }

        state.summary = data.summary;
        state.leaks = data.leaks || [];
        state.lifetime = data.lifetime || state.lifetime;

        // Mostrar panel de resultado
        if (els.decisionResultBox) {
            els.decisionResultBox.removeAttribute('hidden');
            els.decisionResultBox.style.display = 'block';
        }

        // Ocultar botones de acción
        if (els.buttons) {
            els.buttons.hidden = true;
            els.buttons.style.display = 'none';
        }

        // Mostrar feedback principal
        els.feedback.removeAttribute('hidden');
        els.feedback.style.display = 'block';
        els.feedback.className = `feedback ${data.correct ? 'correct' : 'wrong'}`;
        els.feedback.innerHTML = `
            <strong>${data.title}</strong><br>
            Tu decisión: <strong>${data.selected_action}</strong><br>
            Mejor acción: <strong>${data.correct_action}</strong><br><br>
            ${data.explanation}
        `;

        // Mostrar cajas adicionales
        renderDecisionDetails(data);
        renderInsights(data.spot || state.spot);

        // Actualizar estadísticas
        renderSummary(state.summary);
        renderLeaks(state.leaks);
    }

    async function nextSpot(
        module = null,
        mode = state.currentMode || 'normal',
        concept = state.currentConcept || null
    ) {
        const params = new URLSearchParams();

        if (module) {
            params.set('module', module);
        }

        if (mode && mode !== 'normal') {
            params.set('mode', mode);
        }

        if (concept) {
            params.set('concept', concept);
        }

        let url = window.ApexSpotTraining.nextUrl;
        const query = params.toString();

        if (query) {
            url += `?${query}`;
        }

        const response = await fetch(url, {
            headers: { 'Accept': 'application/json' },
        });

        const data = await response.json();

        state.spot = data.spot;

        if (concept) {
            state.currentConcept = concept;
        }

        state.summary = data.summary || state.summary;
        state.leaks = data.leaks || state.leaks;
        state.lifetime = data.lifetime || state.lifetime;

        renderSpot();
    }

    function renderInsights(spot) {
        const insights = spot?.insights || {};

        if (els.lowStakesInsightBox && insights.low_stakes) {
            els.lowStakesInsightBox.removeAttribute('hidden');
            els.lowStakesInsightBox.style.display = '';
            els.lowStakesInsightBox.innerHTML = `
                <div class="insight-card">
                    <div class="insight-title">💰 Pool NL2-NL10</div>
                    <p>${insights.low_stakes}</p>
                </div>
            `;
        }
    }

    function getWorstLeakModule() {
        if (!Array.isArray(state.leaks) || state.leaks.length === 0) return null;
        return state.leaks[0]?.module || null;
    }

    els.buttons.addEventListener('click', (event) => {
        const button = event.target.closest('[data-answer]');
        if (!button) return;

        els.buttons.querySelectorAll('button').forEach((btn) => {
            btn.disabled = true;
        });

        answerSpot(button.dataset.answer);
    });

    els.next.addEventListener('click', () => {
        nextSpot(
            state.currentModule,
            state.currentMode,
            state.currentConcept
        );
    });

    els.practiceLeakBtn?.addEventListener('click', () => {
        const module = getWorstLeakModule();
        if (!module) return;
        state.currentModule = module;
        state.currentMode = 'normal';
        state.currentConcept = null;
        nextSpot(module, state.currentMode, null);
    });

    els.moduleFilter?.querySelectorAll('button').forEach((button) => {
        button.addEventListener('click', () => {
            const module = button.dataset.module || null;
            state.currentModule = module;
            state.currentMode = 'normal';
            state.currentConcept = null;

            els.moduleFilter.querySelectorAll('button').forEach((btn) => btn.classList.remove('is-active'));
            button.classList.add('is-active');
            nextSpot(module, state.currentMode);
        });
    });

    if (els.moduleFilter) {
        const activeModule = state.currentModule || '';
        const activeButton = els.moduleFilter.querySelector(`[data-module="${activeModule}"]`);
        activeButton?.classList.add('is-active');
    }

    renderSpot();
})();

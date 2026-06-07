document.addEventListener('DOMContentLoaded', () => {
    const config = window.ApexSpotTraining;

    if (!config) {
        return;
    }

    let currentSpot = config.initialSpot || null;
    let currentModuleFocus = null;

    const els = {
        spotModule: document.getElementById('spotModule'),
        spotTitle: document.getElementById('spotTitle'),
        spotMeta: document.getElementById('spotMeta'),
        spotActions: document.getElementById('spotActions'),
        spotPot: document.getElementById('spotPot'),
        heroCards: document.getElementById('heroCards'),
        decisionButtons: document.getElementById('decisionButtons'),
        feedbackBox: document.getElementById('feedbackBox'),
        gradeBox: document.getElementById('gradeBox'),
        frequencyBox: document.getElementById('frequencyBox'),
        evBox: document.getElementById('evBox'),
        nextSpotBtn: document.getElementById('nextSpotBtn'),

        summaryTotal: document.getElementById('summaryTotal'),
        summaryCorrect: document.getElementById('summaryCorrect'),
        summaryWrong: document.getElementById('summaryWrong'),
        summaryAccuracy: document.getElementById('summaryAccuracy'),

        leaksList: document.getElementById('leaksList'),
        practiceLeakBtn: document.getElementById('practiceLeakBtn'),
    };

    function renderSpot(spot) {
        if (!spot) return;

        currentSpot = spot;

        els.spotModule.textContent = spot.module_label || '--';
        els.spotTitle.textContent = spot.title || '--';

        const effective = spot.stacks?.hero_bb || 100;
        els.spotMeta.textContent = `${spot.hero_position} vs ${spot.villain_position || 'mesa'} · ${effective} BB efectivos · ${spot.difficulty || 'GTO simplificado'}`;

        els.spotPot.textContent = `Pot: ${spot.pot_bb ?? '--'} BB`;

        renderActions(spot.actions || []);
        renderSeats(spot.table_players || []);
        renderHeroCards(spot.hero_cards || []);
        renderButtons(spot.options || []);

        clearFeedback();
    }

    function renderActions(actions) {
        els.spotActions.innerHTML = '';

        actions.forEach(action => {
            const li = document.createElement('li');
            li.textContent = action;
            els.spotActions.appendChild(li);
        });
    }

    function renderSeats(players) {
        document.querySelectorAll('.seat').forEach(seat => {
            seat.innerHTML = '';
            seat.classList.remove('is-hero', 'is-villain');
        });

        players.forEach(player => {
            const seat = document.querySelector(`.seat[data-position="${player.position}"]`);

            if (!seat) return;

            if (player.is_hero) seat.classList.add('is-hero');
            if (player.is_villain) seat.classList.add('is-villain');

            seat.innerHTML = `
                <span class="seat-pos">${player.position}</span>
                <strong>${player.name}</strong>
                <small>${player.stack_bb} BB</small>
            `;
        });
    }

    function renderHeroCards(cards) {
        els.heroCards.innerHTML = '';

        cards.forEach(card => {
            const div = document.createElement('div');
            div.className = 'hero-card';
            div.textContent = formatCard(card);
            els.heroCards.appendChild(div);
        });
    }

    function formatCard(card) {
        if (!card || card.length < 2) return card;

        const rank = card[0];
        const suit = card[1].toLowerCase();

        const symbols = {
            s: '♠',
            h: '♥',
            d: '♦',
            c: '♣',
        };

        return `${rank}${symbols[suit] || suit}`;
    }

    function renderButtons(options) {
        els.decisionButtons.innerHTML = '';

        options.forEach(option => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'decision-btn';
            button.textContent = option;
            button.dataset.action = option;

            button.addEventListener('click', () => submitAnswer(option));

            els.decisionButtons.appendChild(button);
        });
    }

    async function submitAnswer(action) {
        setButtonsDisabled(true);

        try {
            const response = await fetch(config.answerUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': config.csrf,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ answer: action }),
            });

            const data = await response.json();

            if (!data.success) {
                renderError(data.message || 'No se pudo evaluar la respuesta.');
                return;
            }

            renderFeedback(data);
            renderSummary(data.summary || null);
            renderLeaks(data.leaks || null);
        } catch (error) {
            renderError('Error de conexión al evaluar la respuesta.');
        } finally {
            setButtonsDisabled(false);
        }
    }

    async function loadNextSpot(module = null) {
        clearFeedback();

        let url = config.nextUrl;

        if (module) {
            url += `?module=${encodeURIComponent(module)}`;
        }

        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            const spot = data.spot || data;

            renderSpot(spot);

            if (data.summary) renderSummary(data.summary);
            if (data.leaks) renderLeaks(data.leaks);
        } catch (error) {
            renderError('No se pudo cargar el siguiente spot.');
        }
    }

    function renderFeedback(data) {
        els.feedbackBox.hidden = false;
        els.feedbackBox.className = `feedback feedback-${data.grade || 'unknown'}`;
        els.feedbackBox.innerHTML = `
            <strong>${data.title || 'Resultado'}</strong>
            <p>${data.explanation || ''}</p>
            ${data.main_explanation ? `<p class="muted">${data.main_explanation}</p>` : ''}
            ${data.solver_note ? `<p class="solver-note">${data.solver_note}</p>` : ''}
        `;

        renderGrade(data);
        renderFrequency(data);
        renderEv(data);
    }

    function renderGrade(data) {
        els.gradeBox.hidden = false;
        els.gradeBox.className = `grade-box grade-${data.grade || 'unknown'}`;

        els.gradeBox.innerHTML = `
            <span>Calidad de decisión</span>
            <strong>${gradeLabel(data.grade)}</strong>
        `;
    }

    function renderFrequency(data) {
        els.frequencyBox.hidden = false;

        const frequency = data.frequency !== null && data.frequency !== undefined
            ? `${data.frequency}%`
            : 'Frecuencia no definida';

        els.frequencyBox.innerHTML = `
            <span>Frecuencia GTO simplificada</span>
            <strong>${data.selected_action || '--'} ${frequency}</strong>
        `;
    }

    function renderEv(data) {
        els.evBox.hidden = false;

        const ev = Number(data.ev_score ?? 0);
        const stars = evToStars(ev);

        els.evBox.innerHTML = `
            <span>EV relativo</span>
            <strong>${stars}</strong>
            <small>${ev}/100</small>
        `;
    }

    function evToStars(ev) {
        const filled = Math.max(0, Math.min(5, Math.round(ev / 20)));
        return '★'.repeat(filled) + '☆'.repeat(5 - filled);
    }

    function gradeLabel(grade) {
        return {
            best: 'BEST',
            good: 'GOOD',
            marginal: 'MARGINAL',
            mistake: 'MISTAKE',
            blunder: 'BLUNDER',
            thin: 'MARGINAL',
            wrong: 'MISTAKE',
        }[grade] || 'UNKNOWN';
    }

    function renderSummary(summary) {
        if (!summary) return;

        els.summaryTotal.textContent = summary.total ?? 0;
        els.summaryCorrect.textContent = summary.correct ?? 0;
        els.summaryWrong.textContent = summary.wrong ?? 0;
        els.summaryAccuracy.textContent = `${summary.accuracy ?? 0}%`;
    }

    function renderLeaks(leaks) {
        if (!els.leaksList || !Array.isArray(leaks)) return;

        els.leaksList.innerHTML = '';

        if (leaks.length === 0) {
            els.leaksList.innerHTML = '<p class="muted">Aún no hay datos suficientes.</p>';
            return;
        }

        leaks.forEach(leak => {
            const row = document.createElement('div');
            row.className = 'leak-row';
            row.innerHTML = `
                <span>${leak.module_label}</span>
                <strong>${leak.accuracy}%</strong>
            `;
            els.leaksList.appendChild(row);
        });

        currentModuleFocus = leaks[0]?.module || null;
    }

    function clearFeedback() {
        els.feedbackBox.hidden = true;
        els.feedbackBox.innerHTML = '';

        if (els.gradeBox) {
            els.gradeBox.hidden = true;
            els.gradeBox.innerHTML = '';
        }

        if (els.frequencyBox) {
            els.frequencyBox.hidden = true;
            els.frequencyBox.innerHTML = '';
        }

        if (els.evBox) {
            els.evBox.hidden = true;
            els.evBox.innerHTML = '';
        }
    }

    function renderError(message) {
        els.feedbackBox.hidden = false;
        els.feedbackBox.className = 'feedback feedback-error';
        els.feedbackBox.innerHTML = `<strong>Error</strong><p>${message}</p>`;
    }

    function setButtonsDisabled(disabled) {
        els.decisionButtons.querySelectorAll('button').forEach(button => {
            button.disabled = disabled;
        });
    }

    els.nextSpotBtn?.addEventListener('click', () => {
        loadNextSpot();
    });

    els.practiceLeakBtn?.addEventListener('click', () => {
        if (currentModuleFocus) {
            loadNextSpot(currentModuleFocus);
        }
    });

    renderSpot(currentSpot);
    renderSummary(config.initialSummary || null);
});
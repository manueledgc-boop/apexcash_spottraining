(function () {
    const state = {
        spot: window.ApexSpotTraining.initialSpot,
        summary: window.ApexSpotTraining.initialSummary,
    };

    const els = {
        module: document.getElementById('spotModule'),
        title: document.getElementById('spotTitle'),
        meta: document.getElementById('spotMeta'),
        pot: document.getElementById('spotPot'),
        actions: document.getElementById('spotActions'),
        buttons: document.getElementById('decisionButtons'),
        feedback: document.getElementById('feedbackBox'),
        next: document.getElementById('nextSpotBtn'),
        heroCards: document.getElementById('heroCards'),
        summaryTotal: document.getElementById('summaryTotal'),
        summaryCorrect: document.getElementById('summaryCorrect'),
        summaryWrong: document.getElementById('summaryWrong'),
        summaryAccuracy: document.getElementById('summaryAccuracy'),
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
        els.summaryTotal.textContent = summary.total ?? 0;
        els.summaryCorrect.textContent = summary.correct ?? 0;
        els.summaryWrong.textContent = summary.wrong ?? 0;
        els.summaryAccuracy.textContent = `${summary.accuracy ?? 0}%`;
    }

    function renderSpot() {
        const spot = state.spot;
        els.module.textContent = spot.module_label;
        els.title.textContent = spot.title;
        els.meta.textContent = `Hero ${spot.hero_position} · Villano ${spot.villain_position || 'sin villano directo'} · Stacks ${spot.stacks.hero_bb} BB`;
        els.pot.textContent = `Pot: ${spot.pot_bb} BB`;
        els.actions.innerHTML = spot.actions.map((action) => `<li>${action}</li>`).join('');
        els.heroCards.innerHTML = spot.hero_cards.map(cardHtml).join('');
        els.feedback.hidden = true;
        els.feedback.className = 'feedback';
        els.feedback.innerHTML = '';
        els.buttons.innerHTML = spot.options.map((option) => {
            const cls = option === 'FOLD' ? 'danger' : (option === 'CALL' ? 'secondary' : '');
            return `<button type="button" class="decision-btn ${cls}" data-answer="${option}">${option}</button>`;
        }).join('');
        renderSeats(spot);
        renderSummary(state.summary || {});
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
            els.feedback.hidden = false;
            els.feedback.textContent = data.message || 'No se pudo evaluar el spot.';
            return;
        }
        state.summary = data.summary;
        els.feedback.hidden = false;
        els.feedback.classList.add(data.correct ? 'correct' : 'wrong');
        els.feedback.innerHTML = `
            <strong>${data.title}</strong><br>
            Mejor acción: <strong>${data.correct_action}</strong><br><br>
            ${data.explanation}
        `;
        renderSummary(state.summary);
    }

    async function nextSpot() {
        const response = await fetch(window.ApexSpotTraining.nextUrl, {
            headers: { 'Accept': 'application/json' },
        });
        const data = await response.json();
        state.spot = data.spot;
        state.summary = data.summary;
        renderSpot();
    }

    els.buttons.addEventListener('click', (event) => {
        const button = event.target.closest('[data-answer]');
        if (!button) return;
        answerSpot(button.dataset.answer);
    });

    els.next.addEventListener('click', nextSpot);

    renderSpot();
})();

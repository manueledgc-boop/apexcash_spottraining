(() => {
    const text = window.ApexHandLabText ?? {};
    const routes = window.ApexHandLabRoutes ?? {};

    const positions = ['UTG', 'HJ', 'CO', 'BTN', 'SB', 'BB'];
    const streets = ['preflop', 'flop', 'turn', 'river'];
    const redSuits = ['h', 'd'];
    const ranks = ['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'];
    const suits = [
        { value: 's', label: '♠' },
        { value: 'h', label: '♥' },
        { value: 'd', label: '♦' },
        { value: 'c', label: '♣' },
    ];

    const state = {
        hero: null,
        villain: null,
        actions: { preflop: [], flop: [], turn: [], river: [] },
        currentPayload: null,
    };

    const $ = (id) => document.getElementById(id);
    const els = {
        handLabPanel: $('handLabPanel'),
        labPlayerGate: $('labPlayerGate'),
        labPlayerGateText: $('labPlayerGateText'),
        builderStage: $('handLabBuilderStage'),
        evalStage: $('handLabEvalStage'),
        seats: Array.from(document.querySelectorAll('.lab-seat')),
        evalSeats: Array.from(document.querySelectorAll('.eval-seat')),
        heroStack: $('heroStack'),
        villainStack: $('villainStack'),
        labPot: $('labPot'),
        labStreetLabel: $('labStreetLabel'),
        labHeroVillainSummary: $('labHeroVillainSummary'),
        heroCard1: $('heroCard1'), heroCard2: $('heroCard2'),
        boardCard1: $('boardCard1'), boardCard2: $('boardCard2'), boardCard3: $('boardCard3'), boardCard4: $('boardCard4'), boardCard5: $('boardCard5'),
        labHeroCards: $('labHeroCards'), labBoardCards: $('labBoardCards'),
        createSpotBtn: $('createSpotBtn'), labPreviewBox: $('labPreviewBox'), labPreviewText: $('labPreviewText'), labFormat: $('labFormat'),
        evalSpotType: $('evalSpotType'), evalSpotDetails: $('evalSpotDetails'), evalBoardCards: $('evalBoardCards'), evalPot: $('evalPot'), evalSpr: $('evalSpr'), evalHeroCards: $('evalHeroCards'),
        labDecisionButtons: $('labDecisionButtons'), evalActionList: $('evalActionList'), labFeedbackBox: $('labFeedbackBox'), labFeedbackTitle: $('labFeedbackTitle'), labFeedbackText: $('labFeedbackText'), labAiNotice: $('labAiNotice'),
        createAnotherSpotBtn: $('createAnotherSpotBtn'), practiceRelatedBtn: $('practiceRelatedBtn'),
    };

    function t(key, fallback) { return text[key] ?? fallback; }
    function formatBb(value) { return Number(value || 0).toFixed(1).replace('.0', ''); }
    function csrfToken() { return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? ''; }

    function cardToText(card) {
        if (!card) return '--';
        const rank = card.slice(0, -1);
        const suit = card.slice(-1);
        const suitSymbol = { s: '♠', h: '♥', d: '♦', c: '♣' }[suit] ?? suit;
        return `${rank}${suitSymbol}`;
    }

    function isRedCard(card) { return redSuits.includes((card || '').slice(-1)); }

    function cardOptionsHtml() {
        let html = `<option value="">--</option>`;
        ranks.forEach(rank => {
            suits.forEach(suit => {
                const value = `${rank}${suit.value}`;
                const className = redSuits.includes(suit.value) ? 'red-card-option' : 'black-card-option';
                html += `<option class="${className}" value="${value}">${rank}${suit.label}</option>`;
            });
        });
        return html;
    }

    function selectedCards() {
        return {
            hero: [els.heroCard1.value, els.heroCard2.value].filter(Boolean),
            board: [els.boardCard1.value, els.boardCard2.value, els.boardCard3.value, els.boardCard4.value, els.boardCard5.value].filter(Boolean),
        };
    }

    function allCardSelects() {
        return [els.heroCard1, els.heroCard2, els.boardCard1, els.boardCard2, els.boardCard3, els.boardCard4, els.boardCard5].filter(Boolean);
    }

    function updateCardSelectColorsAndLocks() {
        const values = allCardSelects().map(select => select.value).filter(Boolean);
        allCardSelects().forEach(select => {
            select.classList.toggle('is-red-card-select', isRedCard(select.value));
            select.classList.toggle('is-black-card-select', !!select.value && !isRedCard(select.value));
            Array.from(select.options).forEach(option => {
                if (!option.value) return;
                option.disabled = values.includes(option.value) && option.value !== select.value;
            });
        });
    }

    function setupCardSelectors() {
        allCardSelects().forEach(select => {
            select.innerHTML = cardOptionsHtml();
            select.addEventListener('change', () => {
                const selected = allCardSelects().filter(other => other !== select).map(other => other.value).filter(Boolean);
                if (select.value && selected.includes(select.value)) {
                    select.value = '';
                    showMessage(t('duplicate_card_error', 'Esa carta ya está usada.'));
                }
                renderCards();
            });
        });
    }

    function cardHtml(card, back = false) {
        if (back) return `<div class="lab-card card-back">◆</div>`;
        if (!card) return `<div class="empty-card">--</div>`;
        const redClass = isRedCard(card) ? ' red' : '';
        return `<div class="lab-card${redClass}">${cardToText(card)}</div>`;
    }

    function renderCards() {
        els.labHeroCards.innerHTML = [els.heroCard1.value, els.heroCard2.value].map(card => cardHtml(card)).join('');
        els.labBoardCards.innerHTML = [els.boardCard1.value, els.boardCard2.value, els.boardCard3.value, els.boardCard4.value, els.boardCard5.value].map(card => cardHtml(card)).join('');
        updateCardSelectColorsAndLocks();
        updateLiveSummary();
    }

    function initialActions() {
        return [
            { street: 'preflop', actor: 'SB', type: 'post_blind', size: 0.5, locked: true },
            { street: 'preflop', actor: 'BB', type: 'post_blind', size: 1, locked: true },
        ];
    }

    function resetState() {
        state.hero = null;
        state.villain = null;
        state.actions = { preflop: [], flop: [], turn: [], river: [] };
        state.currentPayload = null;
        allCardSelects().forEach(select => select.value = '');
        els.heroStack.value = 100;
        els.villainStack.value = 100;
        els.labPreviewBox.hidden = true;
        els.labFeedbackBox.hidden = true;
        if (els.builderStage) els.builderStage.hidden = false;
        if (els.evalStage) els.evalStage.hidden = true;
        renderCards(); renderAllActionLists(); updateSeats(); updateLiveSummary();
    }

    function updateSeats() {
        els.seats.forEach(seat => {
            const position = seat.dataset.position;
            const name = seat.querySelector('strong');
            const stack = seat.querySelector('small');

            seat.classList.toggle('is-hero', state.hero === position);
            seat.classList.toggle('is-villain', state.villain === position);

            if (state.hero === position) {
                name.textContent = 'Hero';
                stack.textContent = `${formatBb(els.heroStack.value)} BB`;
            } else if (state.villain === position) {
                name.textContent = t('villain', 'Villano');
                stack.textContent = `${formatBb(els.villainStack.value)} BB`;
            } else {
                name.textContent = t('empty', 'Vacío');
                stack.textContent = '100 BB';
            }
        });

        if (!state.hero) {
            els.labHeroVillainSummary.textContent = t('select_hero_first', 'Selecciona primero el asiento de Hero.');
        } else if (!state.villain) {
            els.labHeroVillainSummary.textContent = `${t('hero', 'Hero')}: ${state.hero} · ${t('select_villain_now', 'Ahora selecciona Villano.')}`;
        } else {
            els.labHeroVillainSummary.textContent = `${t('hero', 'Hero')}: ${state.hero} · ${t('villain', 'Villano')}: ${state.villain}`;
        }

        updateBuilderLock();
    }

    function handleSeatClick(position) {
        if (!state.hero) state.hero = position;
        else if (!state.villain && state.hero !== position) state.villain = position;
        else if (state.hero === position) state.hero = null;
        else if (state.villain === position) state.villain = null;
        else state.villain = position;
        updateSeats(); updateLiveSummary();
    }

    function actionLabel(type) {
        return { post_blind: t('posts','posts'), auto_fold:'Fold', fold:'Fold', check:'Check', call:'Call', limp:'Limp', bet:'Bet', raise:'Raise', allin:'All-in' }[type] ?? type;
    }

    function actionText(action) {
        const size = Number(action.size || 0);
        const sizeText = size > 0 ? ` ${formatBb(size)} BB` : '';
        const autoText = action.auto ? ` · ${t('auto', 'auto')}` : '';
        const lockedText = action.locked ? ` · ${t('forced', 'obligado')}` : '';
        if (action.type === 'post_blind') return `${action.street.toUpperCase()} · ${action.actor} ${t('posts','posts')} ${formatBb(size)} BB${lockedText}`;
        return `${action.street.toUpperCase()} · ${action.actor} ${actionLabel(action.type)}${sizeText}${autoText}`;
    }

    function streetActions(street) { return state.actions[street] || []; }

    function actionListForStreet(street) { return document.querySelector(`[data-action-list="${street}"]`); }

    function renderStreetActions(street) {
        const list = actionListForStreet(street);
        if (!list) return;
        const actions = street === 'preflop' ? [...initialActions(), ...streetActions(street)] : streetActions(street);
        list.innerHTML = actions.length
            ? actions.map(action => `<li${action.locked ? ' class="is-locked-action"' : ''}>${actionText(action)}</li>`).join('')
            : `<li>${t('no_actions_yet', 'Todavía no hay acciones.')}</li>`;
    }

    function renderAllActionLists() { streets.forEach(renderStreetActions); updateLiveSummary(); }

    function flattenedManualActions() { return streets.flatMap(street => streetActions(street)); }

    function actionsWithBlindsAndAutoFolds() {
        const manualPreflop = streetActions('preflop');
        const normalized = [...initialActions()];
        let pointerIndex = 0;
        const actorsWithManual = new Set(manualPreflop.map(action => action.actor));
        const protectedPositions = new Set([state.hero, state.villain].filter(Boolean));

        manualPreflop.forEach(action => {
            const actorIndex = positions.indexOf(action.actor);
            if (actorIndex >= pointerIndex) {
                for (let i = pointerIndex; i < actorIndex; i += 1) {
                    const pos = positions[i];
                    if (protectedPositions.has(pos) || actorsWithManual.has(pos)) continue;
                    normalized.push({ street: 'preflop', actor: pos, type: 'auto_fold', size: 0, auto: true });
                }
                pointerIndex = actorIndex + 1;
            }
            normalized.push(action);
        });

        const decisionStreet = detectDecisionStreet();
        if (decisionStreet !== 'preflop') {
            positions.forEach(pos => {
                const alreadyFolded = normalized.some(action => action.actor === pos && ['fold', 'auto_fold'].includes(action.type));
                const acted = normalized.some(action => action.actor === pos && !action.locked && !action.auto);
                if (!alreadyFolded && !acted && !protectedPositions.has(pos)) {
                    normalized.push({ street: 'preflop', actor: pos, type: 'auto_fold', size: 0, auto: true });
                }
            });
        }

        return [...normalizeActionSizes(normalized), ...normalizeActionSizes(['flop','turn','river'].flatMap(street => streetActions(street)))];
    }

    function actionContribution(action, committed, currentBet) {
        const already = Number(committed[action.actor] || 0);
        const rawSize = Number(action.size || 0);
        if (action.type === 'post_blind') { committed[action.actor] = already + rawSize; return rawSize; }
        if (action.type === 'limp') { const add = Math.max(0, 1 - already); committed[action.actor] = already + add; return add; }
        if (action.type === 'call') { const add = rawSize > 0 ? rawSize : Math.max(0, currentBet - already); committed[action.actor] = already + add; return add; }
        if (['bet','raise','allin'].includes(action.type)) { const target = rawSize > 0 ? rawSize : currentBet; const add = Math.max(0, target - already); committed[action.actor] = already + add; return add; }
        return 0;
    }

    function normalizeActionSizes(actions) {
        const committedByStreet = {}; const currentBetByStreet = {};
        return actions.map(action => {
            const street = action.street || 'preflop';
            committedByStreet[street] ??= {}; currentBetByStreet[street] ??= 0;
            const normalized = { ...action };
            const committed = committedByStreet[street];
            const currentBet = Number(currentBetByStreet[street] || 0);
            if (normalized.type === 'post_blind') { normalized.size = actionContribution(normalized, committed, currentBet); currentBetByStreet[street] = Math.max(currentBet, Number(committed[normalized.actor] || 0)); return normalized; }
            if (normalized.type === 'limp') { normalized.size = actionContribution(normalized, committed, Math.max(1, currentBet)); currentBetByStreet[street] = Math.max(Number(currentBetByStreet[street] || 0), 1); return normalized; }
            if (normalized.type === 'call') { normalized.size = actionContribution(normalized, committed, currentBet); return normalized; }
            if (['bet','raise','allin'].includes(normalized.type)) { const target = Number(normalized.size || 0); normalized.size = actionContribution(normalized, committed, target); currentBetByStreet[street] = Math.max(Number(currentBetByStreet[street] || 0), Number(committed[normalized.actor] || 0)); return normalized; }
            return normalized;
        });
    }

    function selectedBoardByStreet(street = detectDecisionStreet()) {
        const cards = [els.boardCard1.value, els.boardCard2.value, els.boardCard3.value, els.boardCard4.value, els.boardCard5.value];
        if (street === 'preflop') return [];
        if (street === 'flop') return cards.slice(0,3).filter(Boolean);
        if (street === 'turn') return cards.slice(0,4).filter(Boolean);
        return cards.filter(Boolean);
    }

    function detectDecisionStreet() {
        if (streetActions('river').length || els.boardCard5.value) return 'river';
        if (streetActions('turn').length || els.boardCard4.value) return 'turn';
        if (streetActions('flop').length || (els.boardCard1.value || els.boardCard2.value || els.boardCard3.value)) return 'flop';
        return 'preflop';
    }

    function activePlayersAfter(actions, street) {
        const active = new Set(positions);
        actions.forEach(action => { if (['fold', 'auto_fold'].includes(action.type)) active.delete(action.actor); });
        if (state.hero) active.add(state.hero);
        if (state.villain) active.add(state.villain);
        if (street !== 'preflop') return Array.from(active).filter(pos => [state.hero, state.villain].includes(pos));
        return Array.from(active);
    }

    function currentBetInfo(street) {
        const actions = street === 'preflop' ? [...initialActions(), ...streetActions(street)] : streetActions(street);
        const normalized = normalizeActionSizes(actions);
        const committed = {};
        let currentBet = 0;
        normalized.forEach(action => {
            if (['fold','auto_fold','check'].includes(action.type)) return;
            committed[action.actor] = Number(committed[action.actor] || 0) + Number(action.size || 0);
            if (['post_blind','limp','bet','raise','allin'].includes(action.type)) currentBet = Math.max(currentBet, committed[action.actor]);
        });
        return { currentBet, committed, last: streetActions(street).at(-1) ?? null };
    }

    function validateStreetUnlocked(street) {
        if (street === 'preflop') return null;
        if (street === 'flop' && [els.boardCard1.value, els.boardCard2.value, els.boardCard3.value].filter(Boolean).length < 3) return t('missing_flop_before_actions', 'Primero selecciona las 3 cartas del flop.');
        if (street === 'turn' && !els.boardCard4.value) return t('missing_turn_before_actions', 'Primero selecciona la carta del turn.');
        if (street === 'river' && !els.boardCard5.value) return t('missing_river_before_actions', 'Primero selecciona la carta del river.');
        return null;
    }

    function validateAction(street, action) {
        const unlockError = validateStreetUnlocked(street);
        if (unlockError) return unlockError;
        if (!state.hero || !state.villain) return t('missing_hero_villain_before_actions', 'Selecciona Hero y Villano antes de añadir acciones.');
        if (['fold','auto_fold'].includes(action.type) && action.actor === state.hero) return t('hero_fold_not_allowed', 'No crees un spot donde Hero ya foldeó. El spot debe terminar con decisión pendiente para Hero.');
        const streetList = streetActions(street);
        const last = streetList.at(-1);
        if (last && last.actor === action.actor) return t('same_actor_repeated_error', 'El mismo jugador no puede actuar dos veces seguidas en la misma calle.');
        const folded = actionsWithBlindsAndAutoFolds().some(a => a.actor === action.actor && ['fold','auto_fold'].includes(a.type));
        if (folded) return t('folded_player_action_error', 'Un jugador que ya foldeó no puede volver a actuar.');
        const { currentBet, committed } = currentBetInfo(street);
        const actorCommitted = Number(committed[action.actor] || 0);
        const facingBet = currentBet > actorCommitted;
        if (action.type === 'check' && facingBet) return t('check_facing_bet_error', 'No puede hacer check si está enfrentando una apuesta.');
        if (action.type === 'call' && !facingBet && street !== 'preflop') return t('call_without_bet_error', 'No puede hacer call si no hay una apuesta pendiente. Usa check o bet.');
        if (action.type === 'limp' && street !== 'preflop') return t('limp_only_preflop_error', 'Limp solo existe preflop.');

        if (action.type === 'limp' && street === 'preflop' && currentBet > 1) {
            return t('limp_after_raise_error', 'No puede hacer limp después de una subida. Debe ser call, fold, raise o all-in.');
        }
        
        if (action.type === 'bet' && currentBet > 0) return t('bet_when_raise_needed_error', 'Ya existe una apuesta. Usa raise o all-in.');
        if (action.type === 'raise' && currentBet <= 0 && street !== 'preflop') return t('raise_without_bet_error', 'No puede hacer raise si nadie apostó. Usa bet.');
        if (['bet','raise','allin'].includes(action.type) && Number(action.size || 0) <= 0) return t('size_required_error', 'Bet/Raise/All-in necesitan un tamaño en BB.');
        return null;
    }

    function addAction(street, box) {
        if (!state.hero || !state.villain) {
            showMessage(t('select_hero_villain_to_start', 'Primero selecciona Hero y Villano.'));
            return;
        }
        const actor = box.querySelector('[data-action-actor]').value;

        if (!allowedActors().includes(actor)) {
            showMessage(t('invalid_actor_error', 'Solo Hero y Villano pueden realizar acciones manuales en Hand Lab V1.'));
            return;
        }

        const type = box.querySelector('[data-action-type]').value;
        const sizeInput = box.querySelector('[data-action-size]');
        const action = { street, actor, type, size: Number(sizeInput.value || 0) };
 
        if (street === 'preflop' && action.type === 'call' && action.size <= 0) {
            const { currentBet } = currentBetInfo(street);

            if (currentBet <= 1) {
                action.type = 'limp';
                action.size = 1;
            }
        }
 
        const error = validateAction(street, action);
        if (error) { showMessage(error); return; }
        state.actions[street].push(action);
        sizeInput.value = 0;
        renderAllActionLists();
    }

    function showMessage(message) {
        els.labPreviewBox.hidden = false;
        els.labPreviewText.textContent = message;
        els.labPreviewBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function validateCardsForStreet(street) {
        const cards = selectedCards();
        const all = [...cards.hero, ...cards.board];
        if (new Set(all).size !== all.length) return t('duplicate_card_error', 'Hay cartas repetidas.');
        if (cards.hero.length < 2) return t('missing_required', 'Falta seleccionar Hero, Villano y las 2 cartas de Hero.');
        if (street !== 'preflop' && [els.boardCard1.value, els.boardCard2.value, els.boardCard3.value].filter(Boolean).length < 3) return t('missing_flop', 'Para Flop, Turn o River debes seleccionar al menos las 3 cartas del flop.');
        if ((street === 'turn' || street === 'river') && !els.boardCard4.value) return t('missing_turn', 'Para Turn debes seleccionar la carta del turn.');
        if (street === 'river' && !els.boardCard5.value) return t('missing_river', 'Para River debes seleccionar la carta del river.');
        return null;
    }

    function firstPostflopActor(activePlayers) {
        const postflopOrder = ['SB', 'BB', 'UTG', 'HJ', 'CO', 'BTN'];

        return postflopOrder.find(pos => activePlayers.includes(pos)) ?? null;
    }

    function isOpenRaiseSpot() {
        if (!state.hero) return false;

        const street = detectDecisionStreet();

        if (street !== 'preflop') {
            return false;
        }

        const manualPreflopActions = streetActions('preflop')
            .filter(action => !action.locked && !action.auto);

        if (manualPreflopActions.length > 0) {
            return false;
        }

        return true;
    }

    function heroHasPendingDecision(street) {
        const actions = streetActions(street);
        const last = actions.at(-1) ?? null;
        const active = activePlayersAfter(actionsWithBlindsAndAutoFolds(), street);

        if (!state.hero || !active.includes(state.hero)) {
            return false;
        }

        const { currentBet, committed } = currentBetInfo(street);
        const heroCommitted = Number(committed[state.hero] || 0);
        const facingBet = currentBet > heroCommitted;

        if (street === 'preflop') {
            if (isOpenRaiseSpot()) {
                return true;
            }

            return facingBet && (!last || last.actor !== state.hero);
        }

        if (!last) {
            return firstPostflopActor(active) === state.hero;
        }

        if (last.actor === state.hero) {
            return false;
        }

        if (['fold', 'auto_fold', 'call'].includes(last.type)) {
            return false;
        }

        if (facingBet && ['bet', 'raise', 'allin'].includes(last.type)) {
            return true;
        }

        if (!facingBet && last.type === 'check') {
            return true;
        }

        return false;
    }

    function canCreateCurrentSpot() {
        const payload = buildSpotPayload();

        if (!payload.hero_position || !payload.villain_position || payload.hero_cards.length < 2) {
            return false;
        }

        if (payload.hero_position === payload.villain_position) {
            return false;
        }

        if (validateCardsForStreet(payload.street)) {
            return false;
        }

        return heroHasPendingDecision(payload.street);
    }

    function updateCreateSpotButton() {
        if (!els.createSpotBtn) return;

        const canCreate = canCreateCurrentSpot();

        els.createSpotBtn.disabled = !canCreate;
        els.createSpotBtn.classList.toggle('is-disabled', !canCreate);
        els.createSpotBtn.title = canCreate
            ? ''
            : t('create_spot_disabled_hint', 'Solo puedes crear un spot cuando la acción está pendiente en Hero.');
    }

    function validateDecisionPoint(street) {
        if (!heroHasPendingDecision(street)) {
            return t(
                'missing_decision_action_error',
                'Solo puedes crear un spot cuando la acción está pendiente en Hero. Si la calle ya terminó, reparte la siguiente carta.'
            );
        }

        return null;
    }

    function detectSpotType(actions, activePlayers, street) {
        const preflopActions = actions.filter(action =>
            action.street === 'preflop' && !action.locked && !action.auto
        );

        if (street === 'preflop' && preflopActions.length === 0 && state.hero) {
            return `Open Raise ${state.hero} PREFLOP`;
        }

        const aggressive = preflopActions.filter(action =>
            ['raise', 'bet', 'allin'].includes(action.type)
        );

        const hasLimp = preflopActions.some(action =>
            ['limp', 'call'].includes(action.type)
        ) && aggressive.length === 0;

        const hasNoManualAction = preflopActions.length === 0;

        const bvb =
            activePlayers.every(pos => ['SB', 'BB'].includes(pos)) ||
            preflopActions[0]?.actor === 'SB';

        let potType = t('unclassified_pot', 'Unclassified Pot');

        if (hasNoManualAction) potType = t('unclassified_pot', 'Unclassified Pot');
        else if (hasLimp) potType = t('limped_pot', 'Limped Pot');
        else if (aggressive.length === 1) potType = 'SRP';
        else if (aggressive.length === 2) potType = '3Bet Pot';
        else if (aggressive.length >= 3) potType = '4Bet Pot';

        if (bvb) {
            return `BvB ${potType} ${street.toUpperCase()}`;
        }

        const matchup = state.hero && state.villain
            ? `${state.hero} vs ${state.villain}`
            : t('unknown_matchup', 'Unknown matchup');

        return `${matchup} ${potType} ${street.toUpperCase()}`;
    }

    function decisionOptionsFor(payload) {
        const { currentBet, committed } = currentBetInfo(payload.street);
        const heroCommitted = Number(committed[payload.hero_position] || 0);
        const facingBet = currentBet > heroCommitted;
        if (payload.street === 'preflop') return facingBet ? ['Fold','Call','Raise','All-in'] : ['Fold','Call','Raise','All-in'];
        return facingBet ? ['Fold','Call','Raise','All-in'] : ['Check','Bet 33%','Bet 75%','Overbet','All-in'];
    }

    function inferTechnicalSpotType(street) {
        if (street === 'preflop') {
            if (isOpenRaiseSpot()) {
                return 'open_raise';
            }

            return 'preflop_decision';
        }

        if (street === 'flop') {
            return 'flop_uncategorized';
        }

        if (street === 'turn') {
            return 'turn_uncategorized';
        }

        if (street === 'river') {
            return 'river_uncategorized';
        }

        return 'uncategorized';
    }

    function buildSpotPayload() {
        const street = detectDecisionStreet();
        const cards = selectedCards();
        const normalizedActions = actionsWithBlindsAndAutoFolds();
        const activePlayers = activePlayersAfter(normalizedActions, street);
        const pot = normalizedActions.reduce((total, action) => total + Number(action.size || 0), 0);
        const effectiveStack = Math.min(Number(els.heroStack.value || 0), Number(els.villainStack.value || 0));
        const spr = pot > 0 ? effectiveStack / pot : null;
        return {
            format: els.labFormat.value,
            hero_position: state.hero,
            villain_position: state.villain,
            hero_stack_bb: Number(els.heroStack.value || 0),
            villain_stack_bb: Number(els.villainStack.value || 0),
            effective_stack_bb: effectiveStack,
            street,
            pot_bb: pot,
            spr,
            hero_cards: cards.hero,
            board_cards: selectedBoardByStreet(street),
            actions: normalizedActions,
            active_players: activePlayers,
            spot_type: inferTechnicalSpotType(street),
            spot_label: detectSpotType(normalizedActions, activePlayers, street),
            options: [],
        };

    }

    function validatePayload(payload) {
        if (!payload.hero_position || !payload.villain_position || payload.hero_cards.length < 2) return t('missing_required', 'Falta seleccionar Hero, Villano y las 2 cartas de Hero.');
        if (payload.hero_position === payload.villain_position) return t('same_position_error', 'Hero y Villano no pueden ocupar el mismo asiento.');
        return validateCardsForStreet(payload.street) || validateDecisionPoint(payload.street);
    }

    function updateLiveSummary() {
        const payload = buildSpotPayload();
        els.labPot.textContent = `${t('pot','Pot')}: ${formatBb(payload.pot_bb)} BB`;
        els.labStreetLabel.textContent = `${t('street','Calle')}: ${payload.street.toUpperCase()}`;

        updateCreateSpotButton();
    }

    function createSpotPreview() {
        const payload = buildSpotPayload();
        const error = validatePayload(payload);
        if (error) { showMessage(error); return; }
        payload.options = decisionOptionsFor(payload);
        state.currentPayload = payload;
        renderEvaluationStage(payload);
    }

    function renderEvalSeats(payload) {
        const active = new Set(payload.active_players);
        els.evalSeats.forEach(seat => {
            const position = seat.dataset.evalPosition;
            const name = seat.querySelector('strong');
            const small = seat.querySelector('small');
            seat.classList.remove('is-hero', 'is-villain', 'is-inactive');
            if (!active.has(position)) { seat.classList.add('is-inactive'); name.textContent = t('folded','Folded'); small.innerHTML = ''; return; }
            if (payload.hero_position === position) { seat.classList.add('is-hero'); name.textContent = 'Hero'; small.innerHTML = payload.hero_cards.map(card => cardHtml(card)).join(''); return; }
            if (payload.villain_position === position) { seat.classList.add('is-villain'); name.textContent = t('villain','Villano'); small.innerHTML = cardHtml('', true) + cardHtml('', true); return; }
            name.textContent = position; small.innerHTML = cardHtml('', true) + cardHtml('', true);
        });
    }

    function renderEvaluationStage(payload) {
        const board = payload.board_cards.length ? payload.board_cards.map(card => cardHtml(card)).join('') : cardHtml();
        els.builderStage.hidden = true; els.evalStage.hidden = false; els.labFeedbackBox.hidden = true;
        els.evalSpotType.textContent = payload.spot_label ?? payload.spot_type;
        els.evalSpotDetails.textContent = `${payload.hero_position} vs ${payload.villain_position} · ${payload.street.toUpperCase()}`;
        els.evalBoardCards.innerHTML = board;
        els.evalHeroCards.innerHTML = payload.hero_cards.map(card => cardHtml(card)).join('');
        els.evalPot.textContent = `${t('pot','Pot')}: ${formatBb(payload.pot_bb)} BB`;
        els.evalSpr.textContent = `SPR: ${payload.spr ? payload.spr.toFixed(1) : '--'}`;
        els.evalActionList.innerHTML = payload.actions.map(action => `<li>${actionText(action)}</li>`).join('');
        els.labDecisionButtons.innerHTML = payload.options.map(option => `<button type="button" class="decision-btn" data-action="${option}">${option}</button>`).join('');
        els.labDecisionButtons.querySelectorAll('.decision-btn').forEach(button => button.addEventListener('click', () => handleDecision(button.dataset.action)));
        renderEvalSeats(payload);
        window.scrollTo({ top: 0, behavior: 'smooth' });
        console.table(payload);
    }

    async function handleDecision(action) {
        const payload = state.currentPayload; if (!payload) return;
        els.labDecisionButtons.querySelectorAll('button').forEach(button => button.disabled = true);
        els.labFeedbackBox.hidden = false;
        els.labFeedbackTitle.textContent = 'AI Analysis';
        els.labFeedbackText.textContent = `${t('your_decision','Tu decisión')}: ${action}. Analizando la mano...`;
        hideAiNotice();
        els.labFeedbackBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        try {
            if (!routes.aiAnalyze) throw new Error('Missing hand lab AI route.');
            const response = await fetch(routes.aiAnalyze, {
                method: 'POST',
                headers: {
                    'Content-Type':'application/json',
                    'Accept':'application/json',
                    'X-CSRF-TOKEN': csrfToken()
                },
                body: JSON.stringify({ ...payload, selected_action: action })
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }
            const result = await response.json();
            renderDecisionResult(action, result);
        } catch (error) {
            console.error(error);
            els.labFeedbackTitle.textContent = t('save_error_title','No se pudo guardar');
            els.labFeedbackText.textContent = t('save_error_text','Revisa la conexión o vuelve a intentarlo. El spot no fue guardado.');
            showAiNotice('No se pudo conectar. Intenta de nuevo en unos segundos.');
            els.labDecisionButtons.querySelectorAll('button').forEach(button => button.disabled = false);
        }
    }

    function relatedPracticeUrl(payload) {
        if (!payload) return '/spot-training';

        if (payload.street === 'preflop') {
            if (payload.spot_type === 'open_raise') {
                return '/spot-training?module=open_raise';
            }

            return '/spot-training';
        }

        const module = payload.spot_type || '';

        if (payload.street === 'flop') {
            return `/postflop?street=flop&module=${encodeURIComponent(module)}`;
        }

        if (payload.street === 'turn') {
            return `/postflop?street=turn&module=${encodeURIComponent(module)}`;
        }

        if (payload.street === 'river') {
            return `/postflop?street=river&module=${encodeURIComponent(module)}`;
        }

        return '/spot-training';
    }

    function hideAiNotice() {
        if (!els.labAiNotice) return;

        els.labAiNotice.textContent = '';
        els.labAiNotice.style.display = 'none';
    }

    function showAiNotice(message) {
        if (!els.labAiNotice) return;

        els.labAiNotice.textContent = message;
        els.labAiNotice.style.display = message ? 'block' : 'none';
    }

    function renderDecisionResult(action, result) {
        els.labDecisionButtons.innerHTML = '';

        if (result.status === 'ai_analysis') {
            els.labFeedbackTitle.textContent = 'AI Analysis';

            els.labFeedbackText.innerHTML = [
                `<strong>${t('your_decision', 'Your decision')}:</strong> ${result.hero_choice ?? action}`,
                `<strong>${t('best_action', 'Best action')}:</strong> ${result.best_action ?? '--'}`,
                `<strong>Grade:</strong> ${(result.grade ?? '--').toUpperCase()}`,
                result.concept ? `<strong>Category:</strong> ${result.concept}` : '',
                result.gto ? `<strong>GTO:</strong> ${result.gto}` : '',
                result.micro ? `<strong>${t('micro_limits', 'Micro-limits')}:</strong> ${result.micro}` : '',
                result.feedback ? `<strong>Feedback:</strong> ${result.feedback}` : '',
                `<strong>Confidence:</strong> ${result.confidence ?? 0}%`,
            ].filter(Boolean).map(line => `<p>${line}</p>`).join('');

            hideAiNotice();

            return;
        }

        els.labFeedbackTitle.textContent = t('spot_pending_review_title', 'Spot sent for review');
        els.labFeedbackText.textContent = `${t('your_decision', 'Your decision')}: ${action}. ${result.message ?? t('saved_pending_review', 'This spot does not yet have a sufficiently similar approved analysis. It was saved for ApexCash review.')}`;
        showAiNotice(t('ai_unavailable_notice', 'No se recibió un análisis IA válido. Intenta de nuevo.'));
    }

    function bindEvents() {
        els.seats.forEach(seat => {
            seat.addEventListener('click', () => handleSeatClick(seat.dataset.position));
        });

        [els.heroStack, els.villainStack].forEach(input => {
            input.addEventListener('input', () => {
                updateSeats();
                updateLiveSummary();
            });
        });

        document.querySelectorAll('[data-add-action]').forEach(button => {
            button.addEventListener('click', () => {
                addAction(button.dataset.addAction, button.closest('.lab-box'));
            });
        });

        els.createSpotBtn.addEventListener('click', createSpotPreview);
        els.createAnotherSpotBtn.addEventListener('click', resetState);

        if (els.practiceRelatedBtn) {
            els.practiceRelatedBtn.addEventListener('click', () => {
                const url = relatedPracticeUrl(state.currentPayload);
                window.location.href = url;
            });
        }
    }

    function allowedActors() {
       return [state.hero, state.villain].filter(Boolean);
    }

    function updateBuilderLock() {
        const ready = !!state.hero && !!state.villain;

        if (els.handLabPanel) {
            els.handLabPanel.classList.toggle('is-waiting', !ready);
        }

        document
            .querySelectorAll('.hand-lab-panel input, .hand-lab-panel select, .hand-lab-panel button')
            .forEach(el => {
                if (el.closest('.lab-player-gate')) return;
                el.disabled = !ready;
            });

        if (els.labPlayerGateText) {
            els.labPlayerGateText.textContent = ready
                ? `${t('hero', 'Hero')}: ${state.hero} · ${t('villain', 'Villano')}: ${state.villain}`
                : t('select_hero_villain_to_start', 'Primero selecciona Hero y Villano en la mesa para activar el constructor.');
        }

        refreshActorSelectors();
    }

    function actionOrderForStreet(street) {
        if (street === 'preflop') {
            return ['UTG', 'HJ', 'CO', 'BTN', 'SB', 'BB'];
        }

        return ['SB', 'BB', 'UTG', 'HJ', 'CO', 'BTN'];
    }

    function orderedAllowedActorsForStreet(street) {
        const actors = allowedActors();
        const order = actionOrderForStreet(street);

        return order.filter(pos => actors.includes(pos));
    }

    function refreshActorSelectors() {
        document.querySelectorAll('[data-action-actor]').forEach(select => {
            const box = select.closest('.lab-box');
            const addButton = box?.querySelector('[data-add-action]');
            const street = addButton?.dataset.addAction ?? detectDecisionStreet();

            const actors = orderedAllowedActorsForStreet(street);
            const current = select.value;

            select.innerHTML = actors.length
                ? actors.map(pos => `<option value="${pos}">${pos}</option>`).join('')
                : `<option value="">--</option>`;

            if (actors.includes(current)) {
                select.value = current;
            } else if (actors.length) {
                select.value = actors[0];
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => { setupCardSelectors(); bindEvents(); resetState(); });
})();

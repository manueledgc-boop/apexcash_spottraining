# APEXCASH - PROJECT STATUS
Fecha: 2026-06-07

---

# RESUMEN EJECUTIVO

Se tomó una decisión estratégica importante:

❌ Se abandona temporalmente la idea de construir una mesa cash totalmente jugable con persistencia completa, bankroll, sesiones, bots persistentes y estadísticas complejas.

Motivo:

- Complejidad extremadamente alta.
- Coste de desarrollo muy elevado.
- Riesgo de retrasar el producto durante meses.
- El verdadero valor del proyecto está en el entrenamiento.

Nueva visión:

✅ ApexCash se convierte en una plataforma especializada en Spot Training de Cash Games.

Objetivo:

Convertirse en la mejor herramienta de entrenamiento preflop y postflop para jugadores de cash games.

---

# ESTADO ACTUAL

## Backend

Laravel 13 funcionando correctamente.

Estado:

- Login funcional
- Registro funcional
- Dashboard funcional
- Spot Training funcional

Migraciones:

- Solo migraciones base Laravel
- Sin tablas específicas de cash engine
- Base de datos simplificada

---

# ARQUITECTURA SPOT TRAINING

Implementada arquitectura modular.

Estructura:

app/
└── SpotTraining/
    ├── SpotRepository.php
    ├── Modules/
    │   ├── OpenRaiseSpots.php
    │   ├── BtnVs3BetSpots.php
    │   ├── BbVsBtnSpots.php
    │   └── ThreeBetVsOpenSpots.php
    └── Concerns/
        └── BuildsSpotPlayers.php

---

# MÓDULOS IMPLEMENTADOS

## 1. Open Raise

Estado:

Expandido.

Contenido:

- UTG
- HJ
- CO
- BTN
- SB

Total:

25 spots

---

## 2. BTN vs 3Bet

Estado:

Expandido.

Contenido:

- BTN vs SB 3Bet
- BTN vs BB 3Bet

Total:

25 spots

---

## 3. BB vs BTN

Estado:

Expandido.

Contenido:

- Ax suited
- Broadways
- Pocket pairs
- Suited connectors
- Defensas marginales
- Basura offsuit

Total:

25 spots

---

## 4. 3Bet vs Open

Estado:

Versión inicial.

Total:

6 spots

Pendiente ampliar.

---

# SISTEMA DE EVALUACIÓN

Implementado.

Cada spot contiene:

- Acción correcta
- Explicación
- Solver note
- Frecuencia GTO simplificada
- EV relativo
- Calidad de decisión

Calidades:

- BEST
- GOOD
- MARGINAL
- MISTAKE
- BLUNDER

---

# FRONTEND

Estado general:

Muy estable.

Pantalla principal:

- Mesa visual
- Cartas Hero
- Historial de acción
- Botones decisión
- Feedback
- Frecuencia GTO
- EV Score
- Leaks

---

# FILTRO DE MÓDULOS

Implementado.

Disponibles:

- Todos
- Open Raise
- BB vs BTN
- BTN vs 3Bet
- 3Bet vs Open

---

# SISTEMA DE LEAKS

Implementado V1.

Muestra:

- Precisión por módulo
- Peores módulos

Incluye:

- Botón practicar peor leak

Pendiente:

Persistencia real.

---

# JAVASCRIPT

Archivo principal:

public/js/spot-training.js

Responsabilidades:

- Render spots
- Evaluar respuestas
- Actualizar feedback
- Mostrar EV
- Mostrar frecuencia
- Mostrar leaks
- Filtrar módulos

Estado:

Funcional.

---

# CSS

Archivo:

public/assets/css/spot-training.css

Estado:

Estable.

Contiene:

- Layout principal
- Mesa
- Panel lateral
- Botones
- Filtros
- Feedback
- Leaks

---

# SPOTS ACTUALES

Open Raise:
25

BTN vs 3Bet:
25

BB vs BTN:
25

3Bet vs Open:
6

Total actual:
81 spots

---

# PRIORIDAD PARA MAÑANA

## FASE 1

Expandir:

ThreeBetVsOpenSpots.php

Objetivo:

25 spots

Total esperado:

100 spots preflop.

---

## FASE 2

Crear nuevos módulos:

SB vs BTN

Objetivo:
25 spots

BB vs SB

Objetivo:
25 spots

---

## FASE 3

Llegar a:

150-200 spots preflop.

---

# VISIÓN A MEDIO PLAZO

Preflop:

- 300+ spots

Postflop:

- CBet IP
- CBet OOP
- BB vs BTN Flop
- Turn Play
- River Play
- Bluff Catch
- Overbet
- Check Raise

---

# VISIÓN FINAL

ApexCash será una plataforma especializada exclusivamente en Spot Training.

No pretende competir con:

- PokerTracker
- Holdem Manager
- Hand2Note

Tampoco pretende ser una sala de póker.

Objetivo:

Ser el "Duolingo del Cash Game".

Entrenamiento rápido.
Miles de spots.
Corrección inmediata.
Detección de leaks.
Mejora acelerada mediante repetición.
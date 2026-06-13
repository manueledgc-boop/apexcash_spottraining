# APEXCASH - PROJECT STATUS

Fecha: Junio 2026

---

# RESUMEN EJECUTIVO

ApexCash ya dispone de un sistema completo de entrenamiento progresivo basado en XP, precisión y desbloqueo de módulos.

Actualmente existen tres niveles de entrenamiento implementados:

* Preflop
* Postflop Flop
* Postflop Turn

La arquitectura permite seguir ampliando el sistema con River y futuras expansiones sin modificar la estructura principal.

---

# ESTADO GENERAL DEL PROYECTO

## Dashboard

Estado: COMPLETADO

Funcionalidades:

* Login usuario
* Dashboard principal
* Estadísticas globales
* XP acumulada
* Nivel global
* Precisión global
* Progreso de desbloqueo
* Entradas a módulos de entrenamiento
* Leaks persistentes
* Peores spots persistentes

---

# SISTEMA DE PROGRESIÓN

Estado: COMPLETADO

Concepto:

El usuario progresa a través de etapas de aprendizaje.

Ruta de progreso:

Preflop
↓
Flop
↓
Turn
↓
River
↓
Mastery

---

## XP

XP global acumulada.

Todos los módulos suman al mismo progreso general.

---

## Precisión

Cada módulo mantiene precisión independiente.

Ejemplo:

Preflop Accuracy
Flop Accuracy
Turn Accuracy
River Accuracy

Esto permite detectar áreas débiles específicas.

---

# PRELOP TRAINING

Estado: COMPLETADO

Incluye:

* Open Raise
* BB vs BTN
* BB vs SB
* SB vs BTN
* BTN vs 3Bet
* 3Bet Pots
* Recomendaciones
* Leaks
* XP
* Estadísticas persistentes

Aproximadamente:

100 spots

---

# POSTFLOP FLOP TRAINING

Estado: COMPLETADO

Sistema funcional:

* Board dinámico
* Hero
* Villano
* Acción previa
* Pot
* SPR
* Stack efectivo
* GTO simplificado
* Explicación Low Stakes
* Persistencia completa

Módulos actuales:

* C-Bet IP
* Check Back
* Defense vs C-Bet
* Check Raise
* Value Bet
* Semi Bluff

Cantidad actual:

56 spots

Todos persistentes.

---

# POSTFLOP TURN TRAINING

Estado: COMPLETADO (V1)

Arquitectura independiente.

Componentes:

* PostflopTurnSpotRepository
* TurnBarrelSpots
* PostflopTurnTrainingService
* PostflopTurnTrainingController
* turn.blade.php
* postflop-turn-training.js

Persistencia:

* TrainingResults
* TrainingSessions
* UserTrainingStats
* UserLeaks
* UserSpotStats

XP Turn:

Best = 15 XP
Good = 11 XP
Marginal = 5 XP
Mistake = 1 XP
Blunder = 0 XP

Módulos actuales:

* Turn Barrel

Cantidad actual:

10 spots

---

# SISTEMA DE LEAKS

Estado: COMPLETADO

Persistencia permanente.

Detecta:

* Módulos débiles
* Precisión
* Errores frecuentes
* Blunders

Ordenados por Weakness Score.

---

# SISTEMA DE SPOTS

Estado: COMPLETADO

Persistencia individual por spot.

Se registra:

* Veces visto
* Veces acertado
* Veces fallado
* Accuracy
* Última aparición

Preparado para:

* Repetición inteligente
* Priorizar spots débiles
* Algoritmo anti-repetición

---

# SISTEMA ANTI-REPETICIÓN

Estado: PENDIENTE

Objetivo:

Evitar que aparezcan continuamente los mismos spots.

Plan:

* Priorizar spots no vistos recientemente.
* Priorizar spots con peor accuracy.
* Mantener variedad de entrenamiento.

---

# RIVER TRAINING

Estado: NO INICIADO

Pendiente:

* River Value Bet
* River Bluff Catch
* River Thin Value
* River Overbet
* River Hero Call

Objetivo inicial:

50 spots.

---

# TURN V2

Pendiente:

* Turn Probe Bet
* Turn Defense
* Turn Value Bet
* Turn Check Raise

Objetivo:

50 spots totales.

Actualmente:

10 / 50

---

# OBJETIVO DE CONTENIDO

Preflop:
≈100 spots

Flop:
≈100 spots

Turn:
≈50 spots

River:
≈50 spots

Total estimado:

300 spots+

---

# VISIÓN DEL PRODUCTO

ApexCash no pretende ser únicamente una herramienta GTO.

Cada spot debe mostrar:

1. Explicación GTO simplificada.
2. Explicación específica para microlímites (NL2-NL10).

Objetivo:

Ayudar al jugador a entender:

* Qué haría la teoría.
* Qué suele ser más rentable contra el pool real de límites bajos.

---

# PRÓXIMO PASO

Implementar:

Turn Probe Bet

Objetivo:

10 nuevos spots.

Después:

Turn Defense
Turn Value Bet
Turn Check Raise

Y posteriormente:

River V1.

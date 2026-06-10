# PROJECT_STATUS_APEXCASH.md

## Fecha

2026-06

---

# Estado General del Proyecto

ApexCash ha completado la primera versión funcional del motor de entrenamiento preflop basado en conceptos.

La plataforma ya no funciona únicamente como un generador de spots aleatorios.

Ahora es capaz de:

* Registrar resultados por usuario.
* Detectar errores recurrentes.
* Clasificar errores por módulos.
* Clasificar errores por conceptos.
* Mostrar leaks en dashboard.
* Entrenar conceptos específicos.
* Mantener sesiones de entrenamiento dirigidas.

Este es el primer paso real hacia un entrenador personalizado de póker.

---

# Visión del Proyecto

ApexCash no pretende ser un solver GTO.

ApexCash pretende convertirse en el gimnasio mental para jugadores de cash games.

Objetivo principal:

Detectar leaks reales y corregirlos mediante repetición focalizada.

La plataforma está diseñada principalmente para:

* NL2
* NL5
* NL10
* NL25

pero la arquitectura permitirá posteriormente trabajar también con:

* NL50
* NL100
* Regulares avanzados

---

# Arquitectura Actual

## Estructura

Familia
↓
Concepto
↓
Spot

Ejemplo:

BB vs BTN
↓
Ax Offsuit
↓
ATo

---

# Módulos Implementados

## Open Raise

Estado:

COMPLETADO

Incluye:

* Early Position Open
* Late Position Open
* SB Open

Conceptos:

* Ax Suited
* Ax Offsuit
* Broadway Premium
* Broadway Weak
* Suited Connectors
* Weak Suited
* Small Pairs
* Trash Offsuit

---

## BB vs BTN

Estado:

COMPLETADO

Taxonomía completa implementada.

---

## SB vs BTN

Estado:

COMPLETADO

Taxonomía completa implementada.

---

## BB vs SB

Estado:

COMPLETADO

Taxonomía completa implementada.

---

## BTN vs 3Bet

Estado:

COMPLETADO

Conceptos:

* Value Continue
* Ax 4Bet Bluff
* Suited Broadway
* Offsuit Broadway
* Medium Pairs
* Small Pairs
* Suited Connectors
* Borderline Suited
* Premium Continue

---

## 3Bet vs Open

Estado:

COMPLETADO

Conceptos:

* Ax 3Bet Bluff
* Value 3Bet
* Suited Broadway
* Pocket Pairs
* Suited Connectors
* Dominated Offsuit
* Blind Defense

---

# Contenido Disponible

Spots actuales:

150 aproximadamente

Distribución:

6 módulos

25 spots por módulo

---

# Sistema de Persistencia

Implementado.

Se almacenan:

* usuario
* módulo
* familia
* concepto
* concepto_label
* spot
* aciertos
* errores
* accuracy

Tabla:

user_spot_stats

---

# Dashboard

Estado:

COMPLETADO

Incluye:

## Resumen global

* total spots
* correctos
* errores
* accuracy
* XP
* nivel

## Módulos

* mejor módulo
* peor módulo

## Leaks

* leaks por módulo

## Peores Spots

* spots con peor rendimiento

## Concept Leaks

* concepto
* accuracy
* errores

---

# Learning Engine V2

Estado:

FASE 1 COMPLETADA

---

## Entrenamiento por concepto

Implementado.

Ejemplo:

/spot-training?concept=ax_3bet_bluff

La sesión permanece dentro del concepto seleccionado.

El sistema ya no mezcla spots de otros conceptos.

---

## Concept Session Memory

Implementado.

La sesión recuerda:

spot_training.current_concept

Esto evita perder el filtro cuando se solicitan nuevos spots.

---

# Sistema Anti-Repetición

Implementado.

TrainingRecommendationService

Características:

* evita spots recientes
* mantiene lista de últimos spots vistos
* reutiliza spots cuando el conjunto se agota

---

# Lo Próximo

## Prioridad 1

Entrenar peor concepto

Botón:

🔥 Practicar peor concepto

Flujo:

Dashboard
↓
Peor Concepto
↓
Abrir sesión dirigida

---

## Prioridad 2

Entrenar Top 5 conceptos débiles

Sesión automática:

* Concepto #1
* Concepto #2
* Concepto #3
* Concepto #4
* Concepto #5

---

## Prioridad 3

Learning Engine V2 Fase 2

Motor adaptativo.

Más errores:

↓ Más frecuencia.

Más aciertos:

↓ Menos frecuencia.

---

## Prioridad 4

4Bet Pots

Nuevos módulos:

* BTN vs SB 4Bet
* SB vs BTN 4Bet
* BB vs BTN 4Bet
* CO vs BTN 4Bet

---

## Prioridad 5

Postflop Trainer

Fases futuras:

* Flop
* Turn
* River

Taxonomía equivalente:

Familia
↓
Concepto
↓
Spot

---

# Estado del Proyecto

Estado general:

MUY ESTABLE

Contenido:

Suficiente para una V1 funcional.

Arquitectura:

Escalable.

Próximo gran salto:

Entrenamiento personalizado automático basado en leaks y conceptos.

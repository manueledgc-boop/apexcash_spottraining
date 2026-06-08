# PROJECT_STATUS_APEXCASH.md

Fecha: 2026-06-09

---

# ESTADO GENERAL DEL PROYECTO

ApexCash Spot Training se encuentra actualmente en una fase funcional estable.

El sistema ya dispone de:

* Autenticación Laravel.
* Dashboard de usuario.
* Spot Training funcional.
* Persistencia de resultados.
* Persistencia de estadísticas.
* Persistencia de leaks.
* Sistema de XP.
* Dashboard de progreso.
* Learning Engine V1.
* Arquitectura preparada para perfiles de entrenamiento futuros.

Actualmente el sistema funciona correctamente sin errores conocidos críticos.

---

# FUNCIONALIDADES IMPLEMENTADAS

## Sistema de usuarios

Implementado:

* Registro
* Login
* Middleware Auth
* Middleware Verified

Estado:

COMPLETADO

---

## Spot Training

Implementado:

* Open Raise
* BTN vs 3Bet
* BB vs BTN
* BB vs SB
* SB vs BTN
* 3Bet vs Open

Total aproximado:

150 spots preflop.

Estado:

COMPLETADO

---

## Persistencia

Tablas implementadas:

training_sessions

training_results

user_training_stats

user_leaks

training_profiles

Estado:

COMPLETADO

---

## Dashboard

Implementado:

* Accuracy global
* XP
* Nivel
* Leaks
* Mejor módulo
* Peor módulo
* Historial de resultados

Estado:

COMPLETADO

---

## Learning Engine V1

Implementado:

TrainingRecommendationService

Objetivo:

* 60% spots del peor leak
* 40% spots aleatorios

Modo adicional:

/spot-training?mode=leak

Permite practicar únicamente el peor leak detectado.

Estado:

COMPLETADO

---

# CAMBIO DE ARQUITECTURA IMPORTANTE

Se decidió preparar ApexCash para soportar múltiples perfiles de entrenamiento.

Antes:

correct_action

action_grades

Ahora:

answers['gto']

confidence

spot id permanente

Esto permite en el futuro soportar:

* GTO
* Exploit NL2
* Exploit NL10
* Exploit NL25
* Exploit NL50+

sin reescribir el motor.

---

# VISION FUTURA

Se identificó una oportunidad importante:

## MODO EXPLOIT

Problema observado:

Muchos jugadores estudian GTO puro.

Después intentan aplicar exactamente las mismas estrategias en:

* NL2
* NL5
* NL10

y pierden dinero porque la población real no juega GTO.

Ejemplos:

* KTs vs 4Bet
* KJo vs 3Bet
* ATo vs 3Bet

En GTO pueden mezclarse.

En micro límites frecuentemente son folds rentables.

---

## Arquitectura prevista

Cada spot podrá almacenar:

answers:

gto

exploit_micro

exploit_nl10

exploit_nl25

exploit_nl50

Ejemplo:

answers:

gto:
CALL

exploit_micro:
FOLD

El motor decidirá qué respuesta evaluar según el perfil seleccionado.

---

# OBJETIVO DIFERENCIAL DE APEXCASH

La mayoría de entrenadores actuales enseñan:

"¿Qué haría una IA perfecta?"

ApexCash pretende enseñar:

"¿Cómo ganar dinero contra humanos reales?"

La visión futura es combinar:

* Fundamentos GTO
* Explotación de población
* Adaptación por stake
* Comparación GTO vs Exploit

---

# ESTRUCTURA PREPARADA

Preparado:

training_profiles

TrainingRecommendationService

answers[]

confidence

spot id permanente

Pendiente de completar:

Migrar todos los spots existentes al nuevo formato answers['gto'].

Actualmente existe compatibilidad con:

Formato antiguo

y

Formato nuevo

simultáneamente.

---

# PRIORIDADES SIGUIENTES

## FASE 1

Finalizar migración de todos los spots a:

answers['gto']

confidence

spot_id permanente

---

## FASE 2

Anti repetición de spots

Evitar mostrar los últimos 10-20 spots recientes.

---

## FASE 3

Modo Dominio

Mostrar más frecuentemente módulos con accuracy baja.

Mostrar menos frecuentemente módulos dominados.

---

## FASE 4

Alertas de Leak Crítico

Ejemplo:

BB vs BTN

Accuracy: 42%

Mostrar recomendación automática de práctica.

---

## FASE 5

Rachas

Ejemplo:

🔥 10 correctas seguidas

---

## FASE 6

Logros

Medallas

Desbloqueos

Progresión avanzada

---

# ESTADO ACTUAL

Backend:

ESTABLE

Base de datos:

ESTABLE

Dashboard:

ESTABLE

Persistencia:

ESTABLE

Spot Training:

ESTABLE

Learning Engine:

FUNCIONAL

Arquitectura futura GTO/Exploit:

PREPARADA PARCIALMENTE

Progreso global estimado:

35% del sistema completo previsto para ApexCash Train.

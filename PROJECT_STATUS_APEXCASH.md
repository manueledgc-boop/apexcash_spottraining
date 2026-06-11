# APEXCASH PROJECT STATUS

## Fecha: 11 Junio 2026

---

# ESTADO GENERAL DEL PROYECTO

ApexCash dispone actualmente de dos módulos funcionales de entrenamiento:

1. Spot Training Preflop V1
2. Postflop Trainer V1 (Flop)

Ambos módulos funcionan dentro de Laravel utilizando la misma filosofía de entrenamiento:

* Spot único por pantalla.
* Feedback inmediato.
* Explicación GTO simplificada.
* Explicación específica para límites bajos (NL2-NL10).
* Sistema de XP.
* Sistema de leaks.
* Dashboard integrado.
* Responsive mobile-first.

---

# SPOT TRAINING PREFLOP V1

Estado: ESTABLE

Módulos implementados:

* Open Raise
* BB vs BTN
* BTN vs 3Bet
* 3Bet vs Open
* SB vs BTN
* BB vs SB

Características:

* Hero correctamente resaltado.
* Villano correctamente resaltado.
* Feedback inmediato.
* Grado de decisión.
* Frecuencia GTO.
* EV relativo.
* Comentario específico para límites bajos.
* Estadísticas persistentes.
* Leaks persistentes.
* XP y niveles.

Estado actual:

COMPLETADO.

---

# POSTFLOP TRAINER V1

Estado: FUNCIONAL

Street actual:

* Flop

Tipos de spot implementados:

* C-Bet IP
* Check Back IP
* Defensa vs C-Bet
* Check-Raise
* Value Bet
* Semi-Bluff

Información mostrada:

* Board
* Pot
* SPR
* Hero position
* Villain position
* Acción previa
* Textura del board
* Range advantage
* Nut advantage
* Stack efectivo

Sistema de evaluación:

* Acción correcta
* Explicación GTO simplificada
* Frecuencia
* EV Score
* XP

Comentarios específicos:

* GTO simplificado
* Explicación para NL2-NL10

---

# RESPONSIVE DESIGN

Estado: COMPLETADO

Reglas actuales:

## Smartphone vertical

1 columna

Mesa arriba

Panel debajo

## Smartphone horizontal

2 columnas

Mesa izquierda

Panel derecha

## Tablet

2 columnas

## Desktop

2 columnas

Mesa principal izquierda

Panel análisis derecha

---

# DASHBOARD

Estado: FUNCIONAL

Actualmente muestra:

* XP
* Nivel
* Accuracy global
* Spots completados
* Mejor módulo
* Peor módulo
* Leaks persistentes
* Concept leaks
* Actividad reciente

Accesos disponibles:

* Spot Training Preflop
* Spot Training Postflop

---

# LANDING PAGE

Estado: FUNCIONAL

Características:

* Español
* Inglés
* Responsive
* Diseño moderno
* Orientada a entrenamiento

Mensaje principal:

"No memorices tablas. Entrena decisiones reales."

---

# ARQUITECTURA ACTUAL

Laravel 13

Componentes principales:

* DashboardController
* SpotTrainingController
* PostflopTrainingController

Repositorios:

* Spot Repository Preflop
* PostflopSpotRepository

Persistencia:

* user_training_stats
* user_leaks
* estadísticas globales

---

# PROBLEMAS ABIERTOS

Ningún problema crítico.

Detalles menores detectados:

1. Hero/Villano bajo las cartas ocultado temporalmente mediante:

```html
<div class="hero-row" hidden>
```

Funciona correctamente.

Limpieza futura opcional.

2. Algunos textos postflop deben unificarse visualmente con preflop.

No afecta funcionalidad.

---

# SIGUIENTE FASE

POSTFLOP V2

Objetivo:

Expandir el entrenador postflop manteniendo exactamente la misma filosofía que Preflop.

Añadir:

## Turn

* Double barrel
* Delayed c-bet
* Turn probe
* Turn check raise
* Turn value bet

## River

* Thin value
* Bluff catch
* Block bet
* Overbet
* Triple barrel
* Hero call

---

# VISIÓN A LARGO PLAZO

ApexCash no pretende enseñar a memorizar tablas.

Objetivo principal:

Entrenar jugadores mediante repetición de decisiones reales.

Cada spot debe mostrar siempre:

1. Qué haría una estrategia equilibrada (GTO simplificado).

2. Qué suele funcionar mejor contra jugadores recreacionales de NL2-NL10.

El usuario aprende simultáneamente teoría y explotación práctica.

---

# ESTADO ACTUAL

Preflop V1:
100% funcional

Postflop V1:
100% funcional

Dashboard:
100% funcional

Landing:
100% funcional

Proyecto listo para iniciar expansión Postflop V2.

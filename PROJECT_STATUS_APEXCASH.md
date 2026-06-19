PROJECT_STATUS_APEXCASH.md

Fecha: 17/06/2026
Versión: ApexCash V1.0 (Estado actual)

VISIÓN DEL PROYECTO

ApexCash es una plataforma web de entrenamiento de póker Texas Hold'em enfocada en:

Aprendizaje estructurado.
Repetición deliberada.
Detección automática de leaks.
Entrenamiento GTO simplificado.
Entrenamiento explotativo para micro límites.
Progresión guiada por niveles.
Certificación interna ApexCash.

La filosofía principal es:

Aprender por repetición y corrección constante, no por consumir teoría infinita.

ESTADO GENERAL
Módulos completados
Preflop

Estado:

COMPLETADO

Incluye:

Open Raise
BB vs BTN
BB vs SB
SB vs BTN
BTN vs 3Bet
3Bet vs Open

Sistema funcionando:

Spots aleatorios.
Feedback.
XP.
Estadísticas.
Leaks.
Flop

Estado:

COMPLETADO

Incluye:

Cbet IP
Check Back IP
Defense vs Cbet
Check Raise
Value Bet
Semi Bluff

Sistema funcionando.

Turn

Estado:

COMPLETADO

Incluye:

Turn Barrel
Turn Probe
Turn Defense
Turn Value Bet
Turn Check Raise

Sistema funcionando.

River

Estado:

COMPLETADO

Incluye:

River Value Bet
River Bluff Catch
River Bluff
River Thin Value
River Overbet

Sistema funcionando.

ADVANCED TRAINING · MASTERY

Estado:

COMPLETADO

Módulos implementados:

3Bet Pots

20 spots

4Bet Pots

20 spots

Blind vs Blind Advanced

20 spots

Multiway Pots

20 spots

Short Stack Lab

20 spots

Tournament Lab

20 spots

Total Mastery
120 spots

Todos integrados al sistema:

XP
Accuracy
Leaks
Concept leaks
Worst spots
Worst modules
SPOTS ACTUALES
Preflop

100 spots

Flop

50 spots

Turn

50 spots

River

50 spots

Mastery

120 spots

TOTAL ACTUAL
370 spots

Distribución:

100 Preflop
50 Flop
50 Turn
50 River
120 Mastery
SISTEMA DE PROGRESIÓN

Implementado mediante:

TrainingProgressionService
Desbloqueos
Flop

Requisitos:

1000 XP
30 spots mínimos
70% accuracy Preflop
Turn
3000 XP
30 spots mínimos
70% accuracy Flop
River
6000 XP
30 spots mínimos
70% accuracy Turn
Mastery
10000 XP
30 spots mínimos
70% accuracy River
Certification
14000 XP
30 spots mínimos
70% accuracy Mastery
DASHBOARD

Estado:

MUY AVANZADO

Implementado:

XP global
Nivel
Accuracy global
Spots completados
Ruta ApexCash
Mejor módulo
Peor módulo
Leaks persistentes
Leak crítico
Peores spots
Concept leaks
Actividad reciente
Accesos rápidos
Correcciones recientes
Worst Leak

Antes:

Siempre enviaba a Preflop.

Corregido:

Usa TrainingProgressionService.
Envía correctamente a:
Preflop
Flop
Turn
River
Mastery
Critical Leak

Corregido.

Utiliza la misma lógica de rutas.

Iconos de progresión

Estado actual:

🔒 Bloqueado
⏳ En progreso
✅ Completado
🎓 Certification disponible
SISTEMA DE LEAKS

Estado:

COMPLETADO

Incluye:

Leaks persistentes.
Leak crítico.
Peores spots.
Concept leaks.
Accuracy por módulo.
Módulos dominados.
Módulos débiles.
SISTEMA DE XP

Estado:

COMPLETADO

Incluye:

XP acumulado.
Niveles.
Barras de progreso.
Desbloqueos automáticos.
CERTIFICATION

Estado:

EN DESARROLLO
Backend creado
Tabla
certification_attempts

Creada.

Modelo
CertificationAttempt

Creado.

Controller
CertificationController

Creado.

Rutas
/certification
/certification/start

Creadas.

Lógica definida
Examen
75 preguntas

Distribución:

15 Preflop
15 Flop
15 Turn
15 River
15 Mastery
Aprobación

Mínimos:

75% global
60% por bloque
Resultados
No aprobado
Menos de 75%

Bloqueo:

7 días
Aprobado
75% - 89%

Resultado:

APROBADO
Aprobado con Distinción
90%+

Resultado:

APROBADO CON DISTINCIÓN
Certificado

Diseño acordado:

Mostrar:

Nombre.
Fecha.
Código certificado.
Resultado.
Logo ApexCash.

No mostrar:

Porcentaje.
Nota.
Accuracy.
Estadísticas.
Aviso legal

Pendiente de implementar:

La Certificación ApexCash es una certificación privada emitida por ApexCash como reconocimiento interno de formación y evaluación. No constituye una titulación académica oficial ni una acreditación emitida por organismos públicos.

CASH MODE

Estado:

PAUSADO

Base ya desarrollada:

Mesa 6-Max.
Bots persistentes.
Dealer.
Blinds.
Pot.
Reparto.
Evaluador de manos.
Side pots.
Rake.

Pendiente retomar tras finalizar Training + Certification.

PRIORIDADES SIGUIENTES
Prioridad 1

Rediseñar completamente:

Certification

Pantalla profesional.

Prioridad 2

Crear:

CertificationService
Prioridad 3

Generador de examen.

75 preguntas.

Prioridad 4

Motor del examen.

Prioridad 5

Pantalla resultados.

Prioridad 6

Generador PDF del certificado.

VALORACIÓN DEL PROYECTO

Estado real actual:

Preflop        ✅
Flop           ✅
Turn           ✅
River          ✅
Mastery        ✅
Certification  🚧
Cash Mode      ⏸

ApexCash ya no es un prototipo.

La plataforma tiene una ruta de aprendizaje completa, progresión, persistencia, XP, niveles, detección de leaks, entrenamiento estructurado y una certificación final definida.

El principal trabajo restante de la V1 es completar Certification y posteriormente volver al desarrollo del modo Cash.
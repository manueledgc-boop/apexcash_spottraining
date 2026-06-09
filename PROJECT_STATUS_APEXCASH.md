# PROJECT_STATUS_APEXCASH.md

Fecha: 2026-06-09
Proyecto: ApexCash Spot Training / ApexCash Train
Estado: Desarrollo activo

---

# 1. Resumen ejecutivo

ApexCash está evolucionando de una simple colección de spots de póker hacia un sistema de entrenamiento adaptativo para cash games.

La visión actual ya está claramente definida:

> ApexCash no debe ser solo un quiz de manos.
> ApexCash debe detectar errores, agruparlos por patrones, priorizar debilidades y entrenar al jugador de forma dirigida.

La web debe servir principalmente para que jugadores de cash games, especialmente de microlímites y bajos niveles, puedan mejorar de forma práctica. También debe ser útil para jugadores regulares más fuertes que quieran detectar fugas específicas, entrenar spots concretos y trabajar patrones de decisión.

El objetivo diferencial es combinar:

- Fundamentos GTO.
- Explotación real por stake.
- Detección de leaks.
- Entrenamiento adaptativo.
- Aprendizaje por conceptos, no solo por manos sueltas.

---

# 2. Visión del producto

ApexCash debe ser una plataforma sencilla para el usuario, pero potente internamente.

El usuario no debería tener que interpretar estructuras complejas como:

```text
BB_VS_BTN_DEFENSE_AX_OFFSUIT_MEDIUM_NODE_014
```

Debe ver mensajes claros como:

```text
Tu leak principal está en Ax offsuit medios defendiendo BB vs BTN.
```

La arquitectura conceptual del entrenamiento queda definida así:

```text
Módulo
↓
Familia
↓
Concepto
↓
Spot
```

Ejemplo:

```text
BB vs BTN
↓
Defensa BB vs BTN
↓
Ax offsuit medios
↓
ATo
```

Esto permitirá que ApexCash enseñe patrones de póker, no solo respuestas aisladas.

---

# 3. Público objetivo

## 3.1 Jugadores novatos y microlímites

ApexCash debe ayudar especialmente a jugadores de:

- NL2
- NL5
- NL10
- NL25

Necesitan:

- Preflop sólido.
- Eliminar errores graves.
- Aprender cuándo foldear, pagar o 3betear.
- Evitar aplicar GTO de forma mecánica contra poblaciones que no juegan GTO.
- Entrenamiento explotativo por stake en fases futuras.

## 3.2 Regulares buenos

También debe servir a jugadores más avanzados.

Para ellos el valor estará en:

- Detección fina de patrones débiles.
- Comparación GTO vs Exploit.
- Spots complejos.
- Postflop Trainer.
- Análisis por conceptos.
- Entrenamiento repetitivo sobre fugas concretas.

---

# 4. Estado general actual

El proyecto está funcional y estable en su base principal.

Implementado actualmente:

- Autenticación Laravel.
- Dashboard de usuario.
- Spot Training preflop.
- Persistencia de resultados.
- Persistencia de estadísticas globales.
- Persistencia por módulo.
- Persistencia por leak.
- Persistencia por spot individual.
- XP y niveles.
- Learning Engine V1.
- Anti repetición de spots.
- Sistema de dominio visual por módulo.
- Alerta de leak crítico.
- Dashboard con peores spots.
- Práctica directa de spot individual desde dashboard.
- Taxonomía inicial por módulo/familia/concepto/spot.
- Concept Leaks en dashboard.

Estado estimado:

```text
Backend base:                  85-90%
Arquitectura de entrenamiento: 75-80%
Experiencia de usuario:        55-65%
Producto final completo:       40-50%
```

El sistema ya es bastante sólido como base, pero todavía falta mucho valor diferencial: perfiles GTO/Exploit, Learning Engine V2 real, más taxonomía, postflop y feedback más profundo.

---

# 5. Funcionalidades implementadas

## 5.1 Sistema de usuarios

Implementado:

- Registro.
- Login.
- Middleware de autenticación.
- Middleware de verificación.
- Dashboard protegido.

Estado: COMPLETADO.

---

## 5.2 Spot Training Preflop

Módulos actuales:

- Open Raise.
- BTN vs 3Bet.
- BB vs BTN.
- BB vs SB.
- SB vs BTN.
- 3Bet vs Open.

El entrenamiento permite:

- Mostrar un spot.
- Elegir acción.
- Evaluar respuesta.
- Mostrar feedback.
- Guardar resultado.
- Actualizar estadísticas.
- Generar siguiente spot.

Estado: FUNCIONAL.

---

## 5.3 Persistencia

Tablas principales usadas actualmente:

- `training_sessions`
- `training_results`
- `user_training_stats`
- `user_leaks`
- `training_profiles`
- `user_spot_stats`

La persistencia ya guarda:

- Sesiones.
- Resultados individuales.
- Estadísticas globales.
- Estadísticas por módulo.
- Leaks por módulo.
- Estadísticas por spot individual.
- Título del spot.
- Cartas del héroe.
- Taxonomía por familia y concepto.

Estado: FUNCIONAL Y AMPLIADO.

---

## 5.4 Dashboard

Dashboard actual muestra:

- Spots completados.
- Precisión global.
- Aciertos.
- Errores.
- XP.
- Nivel.
- Mejor módulo.
- Peor módulo.
- Leaks persistentes.
- Últimos resultados.
- Estadísticas por módulo.
- Estado visual de dominio.
- Alerta de leak crítico.
- Peores spots concretos.
- Concept Leaks.

Estado: FUNCIONAL.

---

# 6. Learning Engine actual

## 6.1 Learning Engine V1

Implementado:

- Recomendación por peor leak de módulo.
- Modo leak.
- Anti repetición de spots.
- Sistema de dominio básico.
- Selección ponderada por debilidad.

Lógica actual aproximada:

```text
Si hay módulo débil → priorizarlo.
Si no → elegir spot aleatorio.
Evitar repetir spots recientes.
```

También existe:

```text
/spot-training?mode=leak
```

que permite practicar el peor leak detectado.

Estado: FUNCIONAL.

## 6.2 Limitación actual

El Learning Engine todavía no entrena por concepto.

Ahora ya tenemos datos para hacerlo, pero aún no se ha implementado la lógica completa.

Objetivo futuro:

```text
40% concepto débil
25% spot débil concreto
20% módulo débil
15% repaso/aleatorio
```

---

# 7. Anti repetición de spots

Implementado en `TrainingRecommendationService`.

Objetivo:

- Evitar que el usuario vea el mismo spot repetidamente.
- Guardar últimos spots vistos en sesión.
- Excluir los últimos 15 spots si hay alternativas.

Estado: COMPLETADO.

---

# 8. Sistema de dominio visual

Implementado en dashboard.

Criterios actuales:

```text
Accuracy >= 85%  → Dominado
Accuracy 60-84%  → En progreso
Accuracy < 60%   → Necesita trabajo
```

Objetivo:

- Que el usuario no tenga que interpretar solo números.
- Que vea rápidamente qué módulos domina y cuáles debe estudiar.

Estado: COMPLETADO.

---

# 9. Alerta de leak crítico

Implementada en dashboard.

Condición actual aproximada:

```text
total >= 5
accuracy < 65%
```

Muestra:

- Módulo crítico.
- Accuracy.
- Errores.
- Botón para practicar.

Estado: COMPLETADO.

---

# 10. Persistencia por spot individual

Se creó la tabla:

```text
user_spot_stats
```

Campos principales:

```text
user_id
spot_id
module
spot_title
hero_cards
total
correct
wrong
accuracy
last_seen_at
last_wrong_at
family
family_label
concept
concept_label
```

Esto permite pasar de:

```text
BB vs BTN está mal
```

a:

```text
ATo en BB vs BTN tiene 25% de accuracy.
```

Estado: COMPLETADO.

---

# 11. Práctica directa de spot individual

Implementado:

```text
/spot-training?spot_id=...
```

Archivos involucrados:

- `SpotRepository.php`
- `SpotTrainingService.php`
- `SpotTrainingController.php`
- `dashboard.blade.php`

Flujo actual:

```text
Dashboard detecta peor spot
↓
Usuario hace clic
↓
Se abre ese spot exacto
↓
Usuario lo practica
```

Estado: COMPLETADO.

---

# 12. Taxonomía de spots

## 12.1 Decisión estratégica

No se van a crear miles de spots individuales para cada mano.

La estrategia correcta será trabajar con:

```text
Módulo
↓
Familia
↓
Concepto
↓
Spot
```

Esto permite que ApexCash sea sencillo para el usuario, pero potente internamente.

## 12.2 Módulos con taxonomía implementada

Actualmente tienen taxonomía:

```text
BB vs BTN     ✅
SB vs BTN     ✅
BB vs SB      ✅
```

Pendientes:

```text
Open Raise        ⏳
BTN vs 3Bet       ⏳
3Bet vs Open      ⏳
```

---

# 13. Taxonomía BB vs BTN

Familia:

```text
bb_vs_btn_defense
Defensa BB vs BTN
```

Conceptos usados:

- `ax_offsuit_medium` → Ax offsuit medios.
- `ax_suited` → Ases suited.
- `broadway_offsuit` → Broadways offsuit.
- `broadway_suited` → Broadways suited.
- `weak_suited_broadway` → Broadways suited débiles.
- `small_pairs` → Pocket pairs bajos.
- `medium_pairs` → Pocket pairs medios.
- `suited_connectors` → Suited connectors.
- `weak_suited_connector` → Suited connectors débiles.
- `offsuit_connectors` → Conectores offsuit.
- `trash_offsuit` → Basura offsuit.

Estado: COMPLETADO.

---

# 14. Taxonomía SB vs BTN

Familia:

```text
sb_vs_btn_response
SB vs BTN
```

Conceptos usados:

- `value_3bet` → 3Bet por valor.
- `ax_bluff_3bet` → 3Bet bluff con Ax suited.
- `kx_bluff_3bet` → 3Bet bluff con Kx suited.
- `semi_bluff_suited` → Suited semi-bluffs.
- `dominated_offsuit` → Offsuit dominadas.
- `weak_suited_hands` → Suited débiles.
- `small_pairs_oop` → Pocket pairs pequeños OOP.

Estado: COMPLETADO.

---

# 15. Taxonomía BB vs SB

Familia:

```text
bb_vs_sb_response
BB vs SB
```

Conceptos usados:

- `ax_suited` → Ases suited.
- `ax_suited_3bet` → Ases suited 3Bet.
- `value_defense` → Defensa por valor.
- `value_3bet` → 3Bet por valor.
- `suited_connectors` → Suited connectors.
- `suited_broadway` → Broadways suited.
- `weak_suited` → Suited débiles.
- `small_pairs` → Pocket pairs bajos.
- `marginal_offsuit` → Offsuit marginales.
- `trash_offsuit` → Basura offsuit.

Estado: COMPLETADO.

---

# 16. Concept Leaks

Se decidió añadir al dashboard una sección de leaks por concepto.

Objetivo:

No mostrar solo:

```text
ATo
KTo
QJo
```

Sino:

```text
Ax offsuit medios
Broadways offsuit
Suited débiles
```

Esto es mucho más educativo porque el usuario aprende patrones.

Estado: IMPLEMENTADO / EN VALIDACIÓN.

Consulta base usada:

```php
$conceptLeaks = UserSpotStat::query()
    ->where('user_id', $userId)
    ->whereNotNull('concept')
    ->where('total', '>=', 2)
    ->selectRaw('
        concept,
        concept_label,
        family_label,
        SUM(total) as total,
        SUM(correct) as correct,
        SUM(wrong) as wrong,
        ROUND((SUM(correct) / NULLIF(SUM(total), 0)) * 100, 2) as accuracy
    ')
    ->groupBy('concept', 'concept_label', 'family_label')
    ->orderBy('accuracy')
    ->orderByDesc('wrong')
    ->limit(5)
    ->get();
```

---

# 17. Arquitectura GTO / Exploit

La arquitectura futura ya está prevista.

Formato objetivo:

```php
'answers' => [
    'gto' => [...],
    'exploit_nl2' => [...],
    'exploit_nl5' => [...],
    'exploit_nl10' => [...],
]
```

Decisión actual:

No implementar todavía modos Exploit completos.

Motivo:

- La estructura existe.
- Pero todavía no hay suficientes respuestas exploit por spot.
- Meter selector ahora sería más visual que funcional.

Orden correcto futuro:

1. Selector de perfil con GTO activo.
2. Añadir `exploit_nl2` en 20 spots piloto.
3. Comparar GTO vs Exploit.
4. Extender a NL5/NL10.

Estado: PREPARADO PARCIALMENTE.

---

# 18. Por qué no añadir más spots todavía

Decisión estratégica importante:

No seguir añadiendo spots sin estructura.

Motivo:

Una web con muchos spots pero sin inteligencia se convierte en un quiz grande.

ApexCash debe evitar caer en:

```text
Más spots
Más spots
Más spots
```

La prioridad real es:

```text
Pocos/medios spots bien etiquetados
+
Learning Engine inteligente
+
Feedback útil
```

Estimación para preflop:

```text
150-300 spots bien diseñados pueden ser suficientes para una V1 potente.
```

Lo importante es que esos spots estén agrupados por conceptos.

---

# 19. Postflop Trainer futuro

El Postflop Trainer será probablemente la parte de mayor valor de ApexCash.

Pero no debe hacerse todavía.

Orden recomendado:

## Postflop V1

Empezar solo con:

```text
Single Raised Pot
BTN vs BB
Flop solamente
```

No empezar todavía con:

- Turn.
- River.
- 3Bet pots.
- 4Bet pots.
- Multiway.

La arquitectura debe copiar la misma lógica:

```text
Módulo
↓
Familia
↓
Concepto
↓
Spot
```

Ejemplo postflop:

```text
BTN vs BB SRP
↓
CBet Flop
↓
Board seco A-high
↓
AQ en A72r
```

Conceptos postflop futuros:

- Top pair.
- Middle pair.
- Overcards.
- Gutshot.
- Flush draw.
- Backdoor equity.
- Board seco.
- Board conectado.
- Board monotone.
- Board emparejado.
- CBet IP.
- Check-call OOP.
- Check-raise OOP.

Estado: FUTURO.

---

# 20. Archivos principales modificados recientemente

## Backend

- `app/Services/TrainingRecommendationService.php`
- `app/Services/SpotTrainingService.php`
- `app/Http/Controllers/SpotTrainingController.php`
- `app/Http/Controllers/DashboardController.php`
- `app/SpotTraining/SpotRepository.php`
- `app/Models/UserSpotStat.php`

## Módulos de spots

- `app/SpotTraining/Modules/BbVsBtnSpots.php`
- `app/SpotTraining/Modules/SbVsBtnSpots.php`
- `app/SpotTraining/Modules/BbVsSbSpots.php`

## Vistas

- `resources/views/dashboard.blade.php`

## CSS

- `public/assets/css/apexcash-dashboard.css`

## Migraciones

- Creación de `user_spot_stats`.
- Añadido de `spot_title` y `hero_cards`.
- Añadido de `family`, `family_label`, `concept`, `concept_label`.

---

# 21. Qué está funcionando ahora

Funciona actualmente:

- Entrenamiento preflop.
- Guardado de respuestas.
- Cálculo de accuracy global.
- Cálculo de accuracy por módulo.
- Detección de leaks de módulo.
- Detección de peores spots.
- Práctica de spot exacto.
- Guardado de taxonomía en `user_spot_stats`.
- Dashboard con información más educativa.
- Base para detectar leaks de concepto.

---

# 22. Qué falta validar

Hay que validar manualmente:

1. Que nuevos spots de `bb_vs_btn` guarden `family` y `concept`.
2. Que nuevos spots de `sb_vs_btn` guarden `family` y `concept`.
3. Que nuevos spots de `bb_vs_sb` guarden `family` y `concept`.
4. Que `Concept Leaks` aparezca en dashboard cuando haya suficientes registros.
5. Que los registros antiguos con `NULL` no confundan las pruebas.

Para pruebas limpias en desarrollo se puede usar:

```sql
TRUNCATE TABLE user_spot_stats;
```

Luego responder 20-30 spots y consultar:

```sql
SELECT module, family, concept, concept_label, hero_cards, accuracy
FROM user_spot_stats;
```

---

# 23. Problemas detectados y corregidos

## 23.1 Error 500 en botones de acción

Causa:

Se había insertado código relacionado con `$spot` en un método donde `$spot` no existía.

Error probable:

```text
Undefined variable $spot
```

Solución:

- Corregir `updateStat()`.
- Mover `spot_title` y `hero_cards` al método correcto: `updateSpotStat()`.

Estado: CORREGIDO.

## 23.2 Dashboard Blade ParseError

Causa:

Cierre Blade mal emparejado en sección de estadísticas por módulo.

Solución:

- Reemplazar sección por bloque correcto con `@forelse`, `@empty`, `@endforelse`.

Estado: CORREGIDO.

## 23.3 Botón de peor spot no abría spot exacto

Causa:

`spot_id` se leía en controller pero no se usaba.

Solución:

- Añadir soporte `spot_id` en `SpotTrainingController`.
- Añadir `findById()` en `SpotRepository`.
- Ampliar `nextSpot()` en `SpotTrainingService`.

Estado: CORREGIDO.

---

# 24. Prioridades inmediatas

## Prioridad 1

Validar `Concept Leaks` en dashboard con datos reales.

Pasos:

1. Limpiar `user_spot_stats` si hace falta.
2. Entrenar spots de BB vs BTN, SB vs BTN y BB vs SB.
3. Consultar base de datos.
4. Ver dashboard.
5. Confirmar que aparecen conceptos débiles.

## Prioridad 2

Añadir taxonomía a los módulos pendientes:

```text
OpenRaiseSpots.php
BtnVs3BetSpots.php
ThreeBetVsOpenSpots.php
```

## Prioridad 3

Crear Learning Engine V2 basado en concepto.

Propuesta:

```text
40% concepto débil
25% spot débil individual
20% módulo débil
15% aleatorio/repaso
```

## Prioridad 4

Crear entrenamiento por concepto.

URL futura posible:

```text
/spot-training?concept=ax_offsuit_medium
```

## Prioridad 5

Preparar selector de perfil:

```text
GTO
Exploit NL2
Exploit NL5
```

pero solo cuando existan respuestas exploit reales.

---

# 25. Qué NO priorizar ahora

No priorizar todavía:

- Medallas.
- Logros.
- Rachas.
- Más diseño visual.
- Nuevas pantallas estéticas.
- Postflop.
- Miles de spots nuevos.
- Exploit NL2/NL5 completo.

La prioridad actual debe ser que el sistema aprenda a detectar patrones débiles y entrenarlos.

---

# 26. Próximo bloque de trabajo recomendado

## Bloque recomendado para la próxima sesión

```text
1. Verificar Concept Leaks en dashboard.
2. Ajustar visualmente la tarjeta Concept Leaks si hace falta.
3. Añadir taxonomía a OpenRaiseSpots.php.
4. Commit.
5. Añadir taxonomía a BtnVs3BetSpots.php.
6. Commit.
7. Añadir taxonomía a ThreeBetVsOpenSpots.php.
8. Commit.
```

Después de eso:

```text
Learning Engine V2 por concepto.
```

---

# 27. Comandos útiles

Limpiar cache:

```bash
php artisan optimize:clear
```

Ver rutas:

```bash
php artisan route:list
```

Ver estado Git:

```bash
git status
```

Commit recomendado después de validar Concept Leaks:

```bash
git add .
git commit -m "Add concept leak detection to dashboard"
git push
```

Consulta de taxonomía:

```sql
SELECT module, family, concept, concept_label, hero_cards, accuracy
FROM user_spot_stats;
```

Consulta de conceptos agregados:

```sql
SELECT
    concept,
    concept_label,
    family_label,
    SUM(total) as total,
    SUM(correct) as correct,
    SUM(wrong) as wrong,
    ROUND((SUM(correct) / NULLIF(SUM(total), 0)) * 100, 2) as accuracy
FROM user_spot_stats
WHERE concept IS NOT NULL
GROUP BY concept, concept_label, family_label
ORDER BY accuracy ASC;
```

---

# 28. Conclusión

ApexCash ya tiene una base mucho más fuerte que un simple entrenador de spots.

La dirección correcta quedó definida:

```text
Sencillo para el usuario.
Potente por dentro.
Basado en patrones.
Preparado para GTO y Exploit.
Escalable a Postflop.
```

El proyecto ya tiene el núcleo necesario para convertirse en un entrenador adaptativo real.

La prioridad ahora no es añadir más volumen, sino terminar la inteligencia de entrenamiento:

```text
Detectar concepto débil
↓
Mostrarlo claramente
↓
Entrenarlo de forma dirigida
↓
Medir mejora
```

Ese será el salto que diferencie ApexCash de un quiz común y lo acerque a un verdadero coach de cash games.

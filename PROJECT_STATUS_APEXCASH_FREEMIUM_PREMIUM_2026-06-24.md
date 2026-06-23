# PROJECT STATUS – APEXCASH TRAINER

## Fecha: 24 Junio 2026

---

# RESUMEN EJECUTIVO

ApexCash Trainer se encuentra en fase final de estabilización para V1.

El proyecto ya tiene una base funcional muy avanzada:

- Registro y login de usuarios.
- Dashboard de progreso.
- Sistema de XP y niveles.
- Entrenamiento Preflop.
- Entrenamiento Flop.
- Entrenamiento Turn.
- Entrenamiento River.
- Mastery Training.
- Certificación.
- Hand Lab con análisis IA vía Gemini.
- Soporte ES/EN.
- Responsive desktop/móvil.
- Sistema de estadísticas y leaks.
- Base inicial Freemium/Premium.

El dominio definitivo ya está adquirido:

**apexcashtrainer.com**

La prioridad actual es cerrar limpieza, freemium/premium, validación completa y preparación de producción.

---

# ESTADO GENERAL ACTUAL

## Backend

Estado estimado: **95%**

Funcional:

- Autenticación de usuarios.
- Dashboard.
- Progresión XP/niveles.
- Spots por módulos.
- Desbloqueos por progreso.
- Hand Lab AI.
- Middleware de entrenamiento desbloqueado.
- Base de planes Free/Premium.

Pendiente:

- Validar todos los límites Free/Premium.
- Probar usuarios Free, Premium y Admin.
- Revisar errores 500 antes de producción.
- Limpieza final de código antiguo de Hand Lab.

---

## Frontend

Estado estimado: **90-95%**

Funcional:

- Dashboard.
- Pantallas de entrenamiento.
- Hand Lab visual.
- Panel de análisis IA.
- Certificación.
- Responsive general.

Pendiente:

- Revisión visual final.
- Mensajes Premium/Free más comerciales.
- Revisión móvil completa.
- Pulir pantalla Premium.

---

# HAND LAB

## Estado actual

Hand Lab ya no depende de la arquitectura antigua de:

- Similarity.
- Family Resolver.
- Library Match.
- Pending Review como respuesta principal.

La decisión final para V1 fue:

```text
Usuario crea spot
↓
Usuario responde
↓
Se envía a Gemini
↓
Gemini devuelve JSON
↓
Panel derecho muestra análisis
```

Esto simplifica el sistema y permite analizar casi cualquier situación creada por el usuario.

---

## Controlador IA

Archivo principal:

```text
app/Http/Controllers/HandLabAiController.php
```

El controlador actualmente:

- Valida payload del spot.
- Construye prompt.
- Llama a Gemini.
- Usa `responseMimeType = application/json`.
- Usa temperatura baja.
- Valida JSON.
- Valida `best_action` contra las opciones disponibles.
- Valida `grade`.
- Devuelve respuesta limpia al frontend.
- Tiene fallback entre modelos.

Modelo principal recomendado:

```env
GEMINI_MODEL=gemini-2.5-flash
```

Fallback:

```text
gemini-2.5-flash-lite
```

---

## Manejo de errores IA

Se detectaron errores reales de Gemini:

### 503

```text
UNAVAILABLE / high demand
```

Significa modelo saturado.

Solución aplicada:

- Fallback a otro modelo.
- Respuesta controlada `ai_busy`.
- Mensaje amable en frontend.

### 429

```text
RESOURCE_EXHAUSTED / quota exceeded
```

Significa cuota gratuita agotada.

Solución aplicada:

- Respuesta controlada `ai_quota_exceeded`.
- Mensaje amable en frontend.
- No romper pantalla con error técnico.

---

## Prompt actual

El prompt fue simplificado y estabilizado.

Decisiones importantes:

- Sin `concept` en V1.
- JSON estricto.
- GTO, Micro y Feedback en español.
- Máximo 20 palabras por campo principal.
- Best action debe pertenecer a las opciones disponibles.
- Se añadió regla para identificar correctamente la fuerza real de la mano.

Motivo:

Gemini cometió un error llamando `overpair` a 88 en board KKJ. Por eso se reforzó el prompt para evitar errores de lectura básica.

---

# FREEMIUM / PREMIUM

## Decisión estratégica V1

ApexCash tendrá dos planes principales:

## Free

Incluye:

- 20 spots Preflop.
- 10 spots Flop.
- 10 spots Turn.
- 10 spots River.
- 5 análisis Hand Lab por día.
- Dashboard básico.

## Premium

Incluye:

- Todos los spots.
- Mastery Training.
- Certificación.
- Hand Lab ilimitado.
- Leaks avanzados.
- Historial completo.
- Certificados.

---

# IMPLEMENTACIÓN DE PLANES

## Tabla users

Se añadió soporte para:

```text
plan
premium_until
```

Valores previstos:

```text
free
premium
admin
```

---

## Modelo User

Archivo:

```text
app/Models/User.php
```

Métodos implementados:

```php
public function isPremium(): bool
{
    return $this->plan === 'premium'
        && (
            $this->premium_until === null
            || $this->premium_until->isFuture()
        );
}

public function isAdminPlan(): bool
{
    return $this->plan === 'admin';
}

public function hasPremiumAccess(): bool
{
    return $this->isAdminPlan() || $this->isPremium();
}
```

Cast correcto:

```php
'premium_until' => 'datetime'
```

Pendiente corregido:

El atributo `Fillable` debe incluir:

```php
#[Fillable(['name', 'email', 'password', 'plan', 'premium_until', 'is_admin'])]
```

---

# MIDDLEWARES

## training.unlocked

Este middleware no pertenece a Premium.

Controla la progresión educativa:

```text
Preflop
↓
Flop
↓
Turn
↓
River
↓
Mastery
```

Alias esperado:

```php
'training.unlocked' => EnsureTrainingStageUnlocked::class
```

---

## premium

Nuevo middleware para controlar acceso Premium.

Alias esperado:

```php
'premium' => \App\Http\Middleware\EnsurePremiumUser::class
```

---

## Problema detectado

Al añadir el alias `premium`, se creó un segundo bloque `$middleware->alias()` y se perdió el alias anterior `training.unlocked`.

Error generado:

```text
Target class [training.unlocked] does not exist
```

Solución:

En `bootstrap/app.php`, dejar un solo bloque:

```php
$middleware->alias([
    'training.unlocked' => EnsureTrainingStageUnlocked::class,
    'premium' => \App\Http\Middleware\EnsurePremiumUser::class,
]);
```

Luego ejecutar:

```bash
php artisan optimize:clear
```

---

# LÍMITE HAND LAB FREE

## Regla V1

Usuarios Free:

```text
5 análisis Hand Lab por día
```

Usuarios Premium/Admin:

```text
Ilimitado
```

---

## Tabla ai_usage_logs

Se creó o se debe crear:

```text
ai_usage_logs
```

Campos:

```text
id
user_id
feature
used_on
count
created_at
updated_at
```

Índice único:

```text
user_id + feature + used_on
```

Uso:

```text
feature = hand_lab_ai
```

---

## Flujo del límite

Antes de llamar a Gemini:

```text
Si usuario NO es Premium
↓
Buscar registro de uso del día
↓
Si count >= 5
↓
Devolver free_limit_reached
↓
No llamar a Gemini
```

Después de análisis exitoso:

```text
Incrementar count
```

---

## Frontend Hand Lab

Archivo:

```text
public/assets/js/hand-lab.js
```

Ya maneja estados controlados:

```text
ai_quota_exceeded
ai_busy
free_limit_reached
```

Esto evita que el usuario vea errores técnicos feos.

---

# MASTERy Y CERTIFICACIÓN PREMIUM

## Decisión

Mastery y Certificación deben ser Premium.

### Mastery

Debe requerir:

```php
['premium', 'training.unlocked:mastery']
```

### Certificación

Debe requerir:

```php
['premium']
```

La certificación no debe estar disponible para usuarios Free.

---

# SPOTS LIMITADOS FREE

## Regla

Free:

```text
Preflop: 20 spots
Flop: 10 spots
Turn: 10 spots
River: 10 spots
```

Premium:

```text
Todos los spots
```

---

## Implementación recomendada

En repositorios de spots:

```php
if (! Auth::user()?->hasPremiumAccess()) {
    $spots = array_slice($spots, 0, 20); // Preflop
}
```

Postflop:

```php
if (! Auth::user()?->hasPremiumAccess()) {
    $spots = array_slice($spots, 0, 10);
}
```

Archivos esperados:

```text
SpotRepository.php
PostflopSpotRepository.php
PostflopTurnSpotRepository.php
PostflopRiverSpotRepository.php
```

---

# PÁGINA PREMIUM

Debe existir ruta:

```php
Route::view('/premium', 'premium.upgrade')
    ->middleware(['auth', 'verified'])
    ->name('premium.upgrade');
```

Vista esperada:

```text
resources/views/premium/upgrade.blade.php
```

Objetivo:

- Mostrar diferencias Free vs Premium.
- Explicar beneficios.
- Preparar futuro botón de pago.

Por ahora no se implementan pagos.

---

# PAGOS

## Decisión actual

No integrar Stripe/PayPal todavía.

Primero:

- Crear sistema Free/Premium funcional.
- Probar permisos.
- Probar límites.
- Validar UX.

Después:

- Integrar pagos.
- Activar premium automáticamente.
- Controlar expiración con `premium_until`.

---

# PRUEBAS NECESARIAS

## Usuario Free

1. Verificar plan:

```sql
SELECT id, name, plan, premium_until FROM users;
```

2. Hand Lab:

- Hacer 5 análisis.
- Verificar contador en `ai_usage_logs`.
- En el sexto análisis debe salir límite Free.

3. Spots:

- Preflop solo debe cargar 20.
- Flop solo debe cargar 10.
- Turn solo debe cargar 10.
- River solo debe cargar 10.

4. Mastery:

- Debe redirigir a Premium.

5. Certificación:

- Debe redirigir a Premium.

---

## Usuario Premium

Actualizar manualmente:

```sql
UPDATE users SET plan = 'premium', premium_until = NULL WHERE id = 3;
```

Probar:

- Hand Lab ilimitado.
- Todos los spots.
- Mastery accesible si cumple desbloqueo.
- Certificación accesible.

---

## Usuario Admin

Actualizar manualmente:

```sql
UPDATE users SET plan = 'admin', premium_until = NULL WHERE id = 3;
```

Debe tener acceso total.

---

# LIMPIEZA HAND LAB ANTIGUO

## Decisión

No borrar todavía archivos antiguos de:

```text
app/HandLab/
app/HandLab/Library/
app/Services/HandLabSimilarityService.php
```

Motivo:

Pueden servir para V2 como sistema de práctica relacionada o biblioteca interna.

Para V1:

- Desconectar de rutas.
- No usar similarity como análisis.
- No usar concept.
- No usar library matching.

---

# ESTADO FINAL ACTUAL

## Completado

- Hand Lab con IA funcional.
- Fallback de modelos.
- Manejo de errores IA.
- Eliminación de concept en V1.
- Base de planes Free/Premium.
- Métodos Premium en User.
- Middleware Premium creado.
- Límite Hand Lab diseñado.

## Pendiente inmediato

1. Confirmar `bootstrap/app.php` con ambos aliases.
2. Confirmar ruta `/premium`.
3. Confirmar vista `premium.upgrade`.
4. Confirmar migración `ai_usage_logs`.
5. Confirmar límite de 5 análisis/día.
6. Confirmar restricciones de spots Free.
7. Confirmar Mastery Premium.
8. Confirmar Certificación Premium.
9. Probar usuario Free.
10. Probar usuario Premium.

---

# CONCLUSIÓN

ApexCash ya está cerca de una V1 comercial.

La decisión correcta ahora es no añadir nuevas funciones grandes.

Prioridad:

```text
Estabilizar
↓
Limpiar
↓
Probar Free/Premium
↓
Comprar tokens Gemini
↓
Deploy dominio definitivo
↓
Lanzamiento controlado
```


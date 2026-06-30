<?php

return [
    'layout' => [
        'kicker' => 'Cash Game Training System',
        'title' => 'Entrena decisiones. Detecta leaks. Sube de nivel.',
        'subtitle' => 'ApexCash convierte tu estudio de poker en un sistema medible: Preflop, Flop, Turn y River con XP, precisión, leaks y feedback inmediato.',
        'footer_note' => 'ApexCash V1 · Entrenamiento estructurado para Cash Games',
        'stages' => [
            'preflop' => ['title' => 'Preflop', 'text' => 'Base sólida'],
            'flop' => ['title' => 'Flop', 'text' => 'C-bets y defensa'],
            'turn' => ['title' => 'Turn', 'text' => 'Barrels y probes'],
            'river' => ['title' => 'River', 'text' => 'Value, bluffs y calls'],
        ],
    ],

    'fields' => [
        'name' => 'Nombre',
        'email' => 'Email',
        'password' => 'Contraseña',
        'new_password' => 'Nueva contraseña',
        'password_confirmation' => 'Confirmar contraseña',
        'confirm_new_password' => 'Confirmar nueva contraseña',
    ],

    'placeholders' => [
        'name' => 'Tu nombre',
        'email' => 'tu@email.com',
        'password' => '••••••••',
        'new_password' => 'Mínimo 8 caracteres',
        'password_confirmation' => 'Repite tu contraseña',
    ],

    'login' => [
        'badge' => 'Bienvenido',
        'title' => 'ApexCash Trainer',
        'subtitle' => 'Continúa tu progreso, revisa tus leaks y sigue avanzando calle por calle.',
        'remember' => 'Recordarme',
        'forgot_password' => 'Olvidé mi contraseña',
        'submit' => 'Entrar al dashboard',
        'no_account' => '¿Todavía no tienes cuenta?',
        'create_account' => 'Crear cuenta ApexCash',
    ],

    'register' => [
        'badge' => 'Crea tu cuenta',
        'title' => 'ApexCash Trainer',
        'subtitle' => 'Guarda XP, desbloquea módulos y entrena con más de 800 spots de Cash Games.',
        'benefits' => [
            'xp' => ['title' => 'XP', 'text' => 'progreso persistente'],
            'leaks' => ['title' => 'Leaks', 'text' => 'errores detectados'],
            'spots' => ['title' => '800+', 'text' => 'spots de práctica'],
        ],
        'submit' => 'Crear cuenta y empezar',
        'already_registered' => '¿Ya estás registrado?',
        'login' => 'Entrar',
    ],

    'forgot' => [
        'badge' => 'Recuperar acceso',
        'title' => '¿Olvidaste tu contraseña?',
        'subtitle' => 'Introduce tu email y te enviaremos un enlace para crear una nueva contraseña.',
        'submit' => 'Enviar enlace de recuperación',
        'remembered' => '¿Ya recordaste tu contraseña?',
        'back_login' => 'Volver al login',
    ],

    'reset' => [
        'badge' => 'Nueva contraseña',
        'title' => 'Recupera tu cuenta',
        'subtitle' => 'Define una contraseña segura para volver a tu entrenamiento.',
        'submit' => 'Guardar nueva contraseña',
    ],

    'confirm' => [
        'badge' => 'Área segura',
        'title' => 'Confirma tu contraseña',
        'subtitle' => 'Para proteger tu cuenta y tu progreso, confirma tu contraseña antes de continuar.',
        'submit' => 'Confirmar y continuar',
    ],

    'verify' => [
        'badge' => 'Verificación',
        'title' => 'Confirma tu email',
        'subtitle' => 'Antes de empezar, verifica tu correo. Esto permite proteger tu cuenta, guardar tu XP y mantener tu progreso de entrenamiento.',
        'sent' => 'Te hemos enviado un nuevo enlace de verificación.',
        'resend' => 'Reenviar email de verificación',
        'logout' => 'Cerrar sesión',
    ],
    'google' => [
        'continue' => 'Continuar con Google',
        'or_email' => 'o crea una cuenta con tu email',
    ],
];

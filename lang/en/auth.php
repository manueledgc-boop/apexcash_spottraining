<?php

return [
    'layout' => [
        'kicker' => 'Cash Game Training System',
        'title' => 'Train decisions. Detect leaks. Level up.',
        'subtitle' => 'ApexCash turns your poker study into a measurable system: Preflop, Flop, Turn and River with XP, accuracy, leaks and instant feedback.',
        'footer_note' => 'ApexCash V1 · Structured training for Cash Games',
        'stages' => [
            'preflop' => ['title' => 'Preflop', 'text' => 'Solid foundation'],
            'flop' => ['title' => 'Flop', 'text' => 'C-bets and defense'],
            'turn' => ['title' => 'Turn', 'text' => 'Barrels and probes'],
            'river' => ['title' => 'River', 'text' => 'Value, bluffs and calls'],
        ],
    ],

    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'new_password' => 'New password',
        'password_confirmation' => 'Confirm password',
        'confirm_new_password' => 'Confirm new password',
    ],

    'placeholders' => [
        'name' => 'Your name',
        'email' => 'you@email.com',
        'password' => '••••••••',
        'new_password' => 'Minimum 8 characters',
        'password_confirmation' => 'Repeat your password',
    ],

    'login' => [
        'badge' => 'Welcome',
        'title' => 'ApexCash Trainer',
        'subtitle' => 'Continue your progress, review your leaks and keep improving street by street.',
        'remember' => 'Remember me',
        'forgot_password' => 'Forgot password',
        'submit' => 'Enter dashboard',
        'no_account' => 'Don’t have an account yet?',
        'create_account' => 'Create ApexCash account',
    ],

    'register' => [
        'badge' => 'Create your account',
        'title' => 'ApexCash Trainer',
        'subtitle' => 'Save XP, unlock modules and train with more than 800 Cash Game spots.',
        'benefits' => [
            'xp' => ['title' => 'XP', 'text' => 'persistent progress'],
            'leaks' => ['title' => 'Leaks', 'text' => 'detected mistakes'],
            'spots' => ['title' => '800+', 'text' => 'practice spots'],
        ],
        'submit' => 'Create account and start',
        'already_registered' => 'Already registered?',
        'login' => 'Log in',
    ],

    'forgot' => [
        'badge' => 'Recover access',
        'title' => 'Forgot your password?',
        'subtitle' => 'Enter your email and we will send you a link to create a new password.',
        'submit' => 'Send recovery link',
        'remembered' => 'Remembered your password?',
        'back_login' => 'Back to login',
    ],

    'reset' => [
        'badge' => 'New password',
        'title' => 'Recover your account',
        'subtitle' => 'Set a secure password to return to your training.',
        'submit' => 'Save new password',
    ],

    'confirm' => [
        'badge' => 'Secure area',
        'title' => 'Confirm your password',
        'subtitle' => 'To protect your account and your progress, confirm your password before continuing.',
        'submit' => 'Confirm and continue',
    ],

    'verify' => [
        'badge' => 'Verification',
        'title' => 'Confirm your email',
        'subtitle' => 'Before you start, verify your email. This helps protect your account, save your XP and keep your training progress.',
        'sent' => 'A new verification link has been sent to your email.',
        'resend' => 'Resend verification email',
        'logout' => 'Log out',
    ],

    'google' => [
        'continue' => 'Continue with Google',
        'or_email' => 'or create an account with your email',
    ],
];

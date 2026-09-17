<?php

namespace App\Libraries;

/**
 * Ported from application/controllers/auth.php's private _send_email().
 * Loads app/Views/email/{type}-html.php + {type}-txt.php with $data and
 * sends both parts, keeping the app's own templates/branding regardless of
 * which Shield mechanism actually triggers the send.
 */
class AuthMailer
{
    // Ported verbatim from application/language/english/tank_auth_lang.php's
    // auth_subject_* strings.
    private const SUBJECTS = [
        'welcome'         => 'Welcome to %s!',
        'activate'        => 'Welcome to %s!',
        'forgot_password' => 'Forgot your password on %s?',
        'reset_password'  => 'Your new password on %s',
        'change_email'    => 'Your new email address on %s',
    ];

    public function send(string $type, string $email, array $data): bool
    {
        $data['site_name'] = $data['site_name'] ?? 'Tundra';

        $emailService = \Config\Services::email();
        $emailService->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
        $emailService->setReplyTo(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
        $emailService->setTo($email);
        $emailService->setSubject(sprintf(self::SUBJECTS[$type], $data['site_name']));
        $emailService->setMessage(view('email/' . $type . '-html', $data));
        $emailService->setAltMessage(view('email/' . $type . '-txt', $data));

        $sent = $emailService->send(false);
        $emailService->clear();

        return $sent;
    }
}

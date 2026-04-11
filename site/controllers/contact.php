<?php

use Kirby\Cms\App;
use Kirby\Toolkit\V;

return function (App $kirby, $site, $page) {
    $alert   = null;
    $success = false;
    $data    = [
        'name'    => '',
        'email'   => '',
        'phone'   => '',
        'message' => '',
    ];

    if ($kirby->request()->is('POST')) {
        // CSRF protection
        if (csrf(get('csrf')) !== true) {
            $alert = [t('contact.form.error')];
        } else {
            // Collect and sanitize input
            $data = [
                'name'    => trim(get('name', '')),
                'email'   => trim(get('email', '')),
                'phone'   => trim(get('phone', '')),
                'message' => trim(get('message', '')),
            ];

            // Honeypot check (anti-spam)
            if (get('website') !== '') {
                // Silently reject spam
                go($page->url());
                exit;
            }

            // Validation
            $errors = [];
            if (V::blank($data['name'])) {
                $errors[] = t('contact.form.error.name');
            }
            if (!V::email($data['email'])) {
                $errors[] = t('contact.form.error.email');
            }
            if (V::blank($data['message'])) {
                $errors[] = t('contact.form.error.message');
            }

            if (empty($errors)) {
                try {
                    $recipient = $site->email()->or('info@portavecia.it')->value();

                    $kirby->email([
                        'from'     => 'noreply@portavecia.it',
                        'replyTo'  => $data['email'],
                        'to'       => $recipient,
                        'subject'  => 'Porta Vecia — Nuovo messaggio da ' . $data['name'],
                        'body'     => [
                            'text' => "Nome: {$data['name']}\n"
                                    . "Email: {$data['email']}\n"
                                    . "Telefono: {$data['phone']}\n\n"
                                    . "Messaggio:\n{$data['message']}"
                        ],
                    ]);

                    $success = true;
                    // Clear form data on success
                    $data = [
                        'name'    => '',
                        'email'   => '',
                        'phone'   => '',
                        'message' => '',
                    ];
                } catch (Exception $e) {
                    $alert = [t('contact.form.error')];
                }
            } else {
                $alert = $errors;
            }
        }
    }

    return [
        'phone'    => $site->phone()->value(),
        'whatsapp' => $site->whatsapp()->value(),
        'email'    => $site->email()->value(),
        'address'  => $site->address()->value(),
        'hours'    => $site->hours()->toStructure(),
        'alert'    => $alert,
        'success'  => $success,
        'formData' => $data,
    ];
};

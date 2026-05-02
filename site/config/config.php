<?php

// Conditional debug: enabled only when ?_pvdebug=<token> matches.
// TODO: rimuovere dopo aver diagnosticato l'errore sitemap (issue: GSC HTTP 500).
$pvDebugToken = '455dceb0ec2fa7a9cb5e1507466fb29a';
$pvDebug = isset($_GET['_pvdebug']) && hash_equals($pvDebugToken, (string) $_GET['_pvdebug']);

return [
    'debug' => $pvDebug,
    'languages' => true,
    'languages.detect' => false,

    // Email transport via PHP mail()
    'email' => [
        'transport' => [
            'type' => 'mail'
        ]
    ],

    'johannschopplich.helpers.vite' => [
        'entry' => 'src/js/main.js',
        'outDir' => 'dist',
    ],

    // Enable sitemap and robots auto-generation
    'johannschopplich.helpers.sitemap.enabled' => true,
    'johannschopplich.helpers.robots.enabled' => true,

    // Meta defaults (fallback when page fields empty)
    'johannschopplich.helpers.meta.defaults' => function ($kirby, $site, $page) {
        return [
            'description' => $site->description()->value(),
            'opengraph' => [
                'locale' => $kirby->language()->code() === 'it' ? 'it_IT' : 'en_US',
            ],
        ];
    },

    // Thumb srcset presets for responsive images
    'thumbs' => [
        'srcsets' => [
            'default' => [
                '320w'  => ['width' => 320, 'quality' => 80],
                '640w'  => ['width' => 640, 'quality' => 80],
                '960w'  => ['width' => 960, 'quality' => 80],
                '1280w' => ['width' => 1280, 'quality' => 80],
                '1920w' => ['width' => 1920, 'quality' => 80],
            ],
            'default-webp' => [
                '320w'  => ['width' => 320, 'format' => 'webp', 'quality' => 80],
                '640w'  => ['width' => 640, 'format' => 'webp', 'quality' => 80],
                '960w'  => ['width' => 960, 'format' => 'webp', 'quality' => 80],
                '1280w' => ['width' => 1280, 'format' => 'webp', 'quality' => 80],
                '1920w' => ['width' => 1920, 'format' => 'webp', 'quality' => 80],
            ],
            'card' => [
                '300w'  => ['width' => 300, 'height' => 300, 'crop' => 'center', 'quality' => 80],
                '600w'  => ['width' => 600, 'height' => 600, 'crop' => 'center', 'quality' => 80],
            ],
            'card-webp' => [
                '300w'  => ['width' => 300, 'height' => 300, 'crop' => 'center', 'format' => 'webp', 'quality' => 80],
                '600w'  => ['width' => 600, 'height' => 600, 'crop' => 'center', 'format' => 'webp', 'quality' => 80],
            ],
            'gallery' => [
                '400w'  => ['width' => 400, 'quality' => 75],
                '600w'  => ['width' => 600, 'quality' => 75],
                '900w'  => ['width' => 900, 'quality' => 75],
            ],
            'gallery-webp' => [
                '400w'  => ['width' => 400, 'format' => 'webp', 'quality' => 75],
                '600w'  => ['width' => 600, 'format' => 'webp', 'quality' => 75],
                '900w'  => ['width' => 900, 'format' => 'webp', 'quality' => 75],
            ],
        ],
    ],
];

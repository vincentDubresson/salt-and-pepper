<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'sonata' => [
        'path' => './assets/sonata.js',
        'entrypoint' => true,
    ],
    'error' => [
        'path' => './assets/error.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@symfony/ux-live-component' => [
        'path' => './vendor/symfony/ux-live-component/assets/dist/live_controller.js',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    'tom-select' => [
        'version' => '2.4.1',
    ],
    '@orchidjs/sifter' => [
        'version' => '1.1.0',
    ],
    '@orchidjs/unicode-variants' => [
        'version' => '1.1.2',
    ],
    'tom-select/dist/css/tom-select.default.min.css' => [
        'version' => '2.4.1',
        'type' => 'css',
    ],
    'tom-select/dist/css/tom-select.default.css' => [
        'version' => '2.4.1',
        'type' => 'css',
    ],
    'flowbite/plugin' => [
        'version' => '2.5.2',
    ],
    'mini-svg-data-uri' => [
        'version' => '1.4.4',
    ],
    'tailwindcss/plugin' => [
        'version' => '3.4.13',
    ],
    'tailwindcss/defaultTheme' => [
        'version' => '3.4.13',
    ],
    'tailwindcss/colors' => [
        'version' => '3.4.13',
    ],
    'picocolors' => [
        'version' => '1.1.0',
    ],
    'flowbite' => [
        'version' => '2.5.2',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'flowbite-datepicker' => [
        'version' => '1.3.0',
    ],
    'flowbite/dist/flowbite.min.css' => [
        'version' => '2.5.2',
        'type' => 'css',
    ],
];

<?php

return [
    'supported_locales' => [
        'en',
        // 'ar',
        // 'es',
        // ...
    ],

    /**
     * Enable modular support (e.g., nWidart/laravel-modules)
     * When enabled, translations will be loaded from module namespaces
     */
    'modular_enabled' => false,

    /**
     * Translation namespace resolver class
     * You can extend TranslationNamespaceResolver and override the
     * resolveModuleNamespace() method to customize how module namespaces are detected
     */
    'namespace_resolver' => \Osama\LaravelEnums\TranslationNamespaceResolver::class,
];

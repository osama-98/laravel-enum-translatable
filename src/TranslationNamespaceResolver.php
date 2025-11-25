<?php

namespace Osama\LaravelEnums;

use Osama\LaravelEnums\Contracts\TranslationNamespaceResolverInterface;

class TranslationNamespaceResolver implements TranslationNamespaceResolverInterface
{
    /**
     * Resolve the translation namespace for an enum class
     */
    public function resolve(string $enumClass): string
    {
        if (! config('laravel-enums.modular_enabled', false)) {
            return $this->getDefaultNamespace();
        }

        $moduleNamespace = $this->resolveModuleNamespace($enumClass);

        return $moduleNamespace ?? $this->getDefaultNamespace();
    }

    /**
     * Resolve the module namespace from enum class
     * Override this method to customize module detection
     */
    protected function resolveModuleNamespace(string $enumClass): ?string
    {
        // Default implementation for nWidart/laravel-modules
        // Pattern: Modules\{ModuleName}\...
        if (preg_match('/\\\\Modules\\\\([^\\\\]+)\\\\/', $enumClass, $matches)) {
            return strtolower($matches[1]);
        }

        return null;
    }

    /**
     * Get the default namespace when not in a module
     */
    protected function getDefaultNamespace(): string
    {
        return 'enums';
    }
}

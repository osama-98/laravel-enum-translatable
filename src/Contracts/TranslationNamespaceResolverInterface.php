<?php

namespace Osama\LaravelEnums\Contracts;

interface TranslationNamespaceResolverInterface
{
    public function resolve(string $enumClass): string;
}

<?php

namespace Osama\LaravelEnums\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeEnumCommand extends GeneratorCommand
{
    protected $name = 'make:enum';

    protected $description = 'Generate a string backed enum with EnumTranslatable by default.';

    protected $type = 'Enum';

    protected function getStub(): string
    {
        return $this->resolveStubPath("/stubs/enum-{$this->getEnumType()}.stub");
    }

    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../../resources'.$stub;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Enums';
    }

    protected function qualifyClass($name): string
    {
        if (! Str::endsWith($name, 'Enum')) {
            $name = $name.'Enum';
        }

        return parent::qualifyClass($name);
    }

    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        return $this->replaceTraits($stub);
    }

    protected function replaceTraits(string $stub): string
    {
        $traits = $this->getSelectedTraits();

        if (empty($traits)) {
            return str_replace(['{{ trait_imports }}', '{{ trait_uses }}'], ['', ''], $stub);
        }

        $imports = collect($traits)
            ->map(fn (string $trait) => "use Osama\\LaravelEnums\\Concerns\\{$trait};")
            ->implode("\n");

        $uses = "\n    use ".implode(', ', $traits).';';

        return str_replace(
            ['{{ trait_imports }}', '{{ trait_uses }}'],
            ["\n\n".$imports, $uses],
            $stub
        );
    }

    protected function getSelectedTraits(): array
    {
        if ($this->option('arrayable')) {
            return ['EnumArrayable'];
        }

        if ($this->option('wrappable')) {
            return ['EnumWrappable'];
        }

        return ['EnumTranslatable'];
    }

    protected function getEnumType(): string
    {
        return $this->option('int') ? 'integer' : 'string';
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the enum (e.g. UserStatus or Admin/UserStatus).'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['int', null, InputOption::VALUE_NONE, 'Create an integer backed enum.'],
            ['arrayable', null, InputOption::VALUE_NONE, 'Use EnumArrayable instead of EnumTranslatable (includes EnumWrappable).'],
            ['wrappable', null, InputOption::VALUE_NONE, 'Use EnumWrappable instead of EnumTranslatable.'],
        ];
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => ['What should the enum be named?', 'E.g. UserStatus or Admin/UserStatus'],
        ];
    }
}

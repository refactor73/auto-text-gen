<?php

declare(strict_types=1);

namespace AutoTextGen;

class Context
{
    private array $variables;

    public function __construct(array $variables)
    {
        $this->variables = $variables;
    }

    public static function fromArray(array $variables): self
    {
        return new self($variables);
    }

    public function get(string $variable): string
    {
        return (string)($this->variables[$variable] ?? '');
    }

    public function add(string $variable, string $value): void
    {
        $this->variables[$variable] = $value;
    }
}

<?php

declare(strict_types=1);

namespace AutoTextGen;

class DecisionTable
{
    private array $decisions;

    public function __construct(array $decisions)
    {
        $this->decisions = $decisions;
    }

    public static function fromArray(array $decisions): self
    {
        return new self($decisions);
    }

    public function conditionsAreTrue(array $conditions): bool
    {
        foreach ($conditions as $condition) {
            if (! $this->isTrue($condition)) {
                return false;
            }
        }

        return true;
    }

    private function isTrue(string $name): bool
    {
        return ($this->decisions[str_replace('$', '', $name)] ?? false) === true;
    }
}

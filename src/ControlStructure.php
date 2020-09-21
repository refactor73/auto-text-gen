<?php

namespace AutoTextGen;

class ControlStructure
{
    private array $conditions;

    private string $statement;

    private ?string $else;

    public static function create(
        array $conditions,
        string $statement,
        ?string $else = null
    ): self {
        $self = new self();
        $self->conditions = $conditions;
        $self->statement = $statement;
        $self->else = $else;

        return $self;
    }

    public function conditions(): array
    {
        return $this->conditions;
    }

    public function statement(): string
    {
        return $this->statement;
    }

    public function else(): ?string
    {
        return $this->else;
    }
}

<?php

namespace Pabloleone\ArtisanUi\Models\Decorators;

abstract class Decorator implements DecoratorInterface
{
    protected string $output = '';

    protected string $description = '';

    public function getParsedOutput(): string
    {
        return $this->output;
    }

    public function setRawOutput(string $value): self
    {
        $this->output = $value;
        return $this;
    }

    public function getParsedDescription(): string
    {
        return $this->description;
    }

    public function setRawDescription(string $value): self
    {
        $this->description = $value;
        return $this;
    }
}

<?php

namespace Pabloleone\ArtisanUi\Models\Decorators;

interface DecoratorInterface
{
    public function getParsedOutput(): string;

    public function setRawOutput(string $value): self;

    public function getParsedDescription(): string;

    public function setRawDescription(string $value): self;
}

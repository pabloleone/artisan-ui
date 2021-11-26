<?php

namespace Pabloleone\ArtisanUi\Models;

class Section
{
    public string $id;

    public array $commands = [];

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function addCommand(Command $command): void
    {
        array_push($this->commands, $command);
    }
}

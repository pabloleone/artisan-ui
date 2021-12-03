<?php

namespace Pabloleone\ArtisanUi\Models;

class Section
{
    public string $id;

    public array $commands = [];

    public function setSectionId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function addCommand(Command $command): void
    {
        array_push($this->commands, $command);
    }
}

<?php

namespace Pabloleone\ArtisanUi\Models;

class Section
{
    private string $id;

    private array $commands = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function addCommand(Command $command): void
    {
        array_push($this->commands, $command);
    }
}

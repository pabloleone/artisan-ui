<?php

namespace Pabloleone\ArtisanUi\Models;

class Command
{
    private $artisanCommand;

    public function __construct($command)
    {
        $this->artisanCommand = $command;
    }

    public function getName(): string
    {
        return $this->artisanCommand->getName();
    }

    public function getDescription(): string
    {
        return $this->artisanCommand->getProcessedHelp();
    }

    public function getUsage(): string
    {
        return $this->artisanCommand->getSynopsis();
    }

    public function getOptions(): array
    {
        return $this->artisanCommand->getDefinition()->getOptions();
    }

    public function getArguments(): array
    {
        return $this->artisanCommand->getDefinition()->getArguments();
    }
}

<?php

namespace Pabloleone\ArtisanUi\Models;

use Illuminate\Support\Facades\Artisan;
use Pabloleone\ArtisanUi\Models\Decorators\Decorator;
use Pabloleone\ArtisanUi\Models\Decorators\Proxy;
use Symfony\Component\Console\Command\Command as ArtisanCommand;

class Command
{
    private ArtisanCommand $artisanCommand;

    private string $exitCode;

    private array $parameters;

    public function setCommand(ArtisanCommand $command): self
    {
        $this->artisanCommand = $command;
        return $this;
    }

    public function getName(): string
    {
        return $this->artisanCommand->getName();
    }

    public function getDescription(): string
    {
        return $this->getDecorator()
            ->setRawDescription($this->artisanCommand->getProcessedHelp())
            ->getParsedDescription();
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

    public function run(): void
    {
        $this->setExitCode(
            Artisan::call($this->artisanCommand->getName(), $this->getParameters())
        );
    }

    public function setParameters(array $values): void
    {
        $this->parameters = $values;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getOutput(): string
    {
        return $this->getDecorator()->setRawOutput(Artisan::output())->getParsedOutput();
    }

    public function getExitCode(): string
    {
        return $this->exitCode;
    }

    public function setExitCode(string $value): void
    {
        $this->exitCode = $value;
    }

    private function getDecorator(): Decorator
    {
        $decorator = config('artisan-ui.decorators')[$this->getName()] ?? Proxy::class;
        return new $decorator();
    }
}

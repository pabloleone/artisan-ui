<?php

namespace Pabloleone\ArtisanUi;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Pabloleone\ArtisanUi\Models\Command;
use Pabloleone\ArtisanUi\Models\Section;

class ArtisanUi
{
    public function __construct()
    {
        $this->artisanCommands = collect(Artisan::all());
    }

    public function getAvailableCommands(): Collection
    {
        return $this->artisanCommands->sort()->filter(function ($command) {
            return !in_array($command->getName(), config('artisan-ui.excluded'));
        });
    }

    public function getAvailableSectionsFromCommands(): Collection
    {
        return $this->getAvailableCommands()
            ->map(function ($command) {
                $commandSectionId = '';
                $segments = explode(':', $command->getName());
                if (count($segments) > 1) {
                    $commandSectionId = $segments[0];
                }
                return $commandSectionId;
            })
            ->unique()
            ->values()
            ->sort();
    }

    public function getSectionsTree(): Collection
    {
        $commands = $this->getAvailableCommands();
        return $this->getAvailableSectionsFromCommands()->map(function ($sectionId) use ($commands) {
            $section = new Section();
            $section->setSectionId($sectionId);

            $sectionCommands = $this->getCommandsBySectionId($sectionId, $commands)->sort();

            foreach ($sectionCommands as $sectionCommand) {
                $command = new Command();
                $command->setCommand($sectionCommand);
                $section->addCommand($command);
            }

            return $section;
        });
    }

    private function getCommandsBySectionId(string $sectionId, $commands): Collection
    {
        return $commands->filter(function ($command) use ($sectionId) {
            if ($sectionId === "" && strpos($command->getName(), ':') === false) {
                return true;
            }
            $commandIdSegments = explode(':', $command->getName());
            if ($sectionId !== '' && strpos($commandIdSegments[0], $sectionId) !== false) {
                return true;
            }
            return false;
        });
    }
}

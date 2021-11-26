<?php

namespace Pabloleone\ArtisanUi;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Pabloleone\ArtisanUi\Models\Command;
use Pabloleone\ArtisanUi\Models\Section;

class ArtisanUi
{
    private Collection $sections;

    private Collection $artisanCommands;

    public function __construct()
    {
        $this->artisanCommands = collect(Artisan::all());

        $availableCommands = $this->getAvailableCommands();

        $availableSections = $this->getAvailableSectionsFromCommands($availableCommands);

        $this->sections = $this->getSections($availableSections, $availableCommands);
    }

    public function get()
    {
        return $this->sections;
    }

    private function getAvailableCommands(): Collection
    {
        return $this->artisanCommands->sort()->filter(function ($command) {
            return !in_array($command->getName(), config('artisan-ui.excluded'));
        });
    }

    private function getAvailableSectionsFromCommands(Collection $commands): Collection
    {
        return $commands->map(function ($command) {
            $segments = explode(':', $command->getName());
            if (count($segments) > 1) {
                $segments = $segments[0];
            } else {
                $segments = '';
            }
            return $segments;
        })->unique()->values()->sort();
    }

    public function getSections(Collection $sections, Collection $commands): Collection
    {
        return $sections->map(function ($sectionId) use ($commands) {
            $section = new Section($sectionId);
            $commands->filter(function ($command) use ($sectionId) {
                if ($sectionId === "" && strpos($command->getName(), ':') === false) {
                    return true;
                }
                if ($sectionId !== '' && strpos(explode(':', $command->getName())[0], $sectionId) !== false) {
                    return true;
                }
                return false;
            })->sort()->each(function ($sectionCommand) use ($section) {
                $section->addCommand(new Command(Artisan::all()[$sectionCommand->getName()]));
            });
            return $section;
        });
    }
}

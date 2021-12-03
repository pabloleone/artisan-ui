<?php

namespace Pabloleone\ArtisanUi\Http\Controllers;

use Pabloleone\ArtisanUi\Models\Command;
use Illuminate\Routing\Controller as BaseController;
use Pabloleone\ArtisanUi\ArtisanUi;
use Pabloleone\ArtisanUi\Http\Requests\Execute;
use Illuminate\Support\Facades\App;

class Artisan extends BaseController
{
    private Command $command;

    private ArtisanUi $artisanUi;

    public function __construct(Command $command, ArtisanUi $artisanUi)
    {
        $this->command = $command;
        $this->artisanUi = $artisanUi;
    }

    public function main()
    {
        $sections = $this->artisanUi->getSectionsTree();

        return view(
            'artisan-ui::themes.'.config('artisan-ui.theme').'.main',
            compact('sections')
        );
    }

    public function execute(Execute $request)
    {
        $commandId = $request->input('command');

        $this->command->setCommand($request->artisanCommands[$commandId]);

        $parameters = $request->getParameters(
            $request->input('command'),
            $request->input('arguments'),
            $request->input('options'),
        );

        $this->command->setParameters($parameters->toArray());

        $exitCode = $this->command->run();

        $output = $this->command->getOutput();

        $sections = $this->artisanUi->getSectionsTree();

        // TODO: Display confirmation alert with custom messages for certain
        // commands which execution can cause disruption or when env is
        // production (ex. down command)
        return view(
            'artisan-ui::themes.'.config('artisan-ui.theme').'.main',
            compact('exitCode', 'output', 'sections', 'commandId')
        );
    }
}

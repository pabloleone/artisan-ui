<?php

namespace Pabloleone\ArtisanUi\Http\Controllers;

use Pabloleone\ArtisanUi\Events\AfterExecuteArtisanCommand;
use Pabloleone\ArtisanUi\Events\BeforeExecuteArtisanCommand;
use Pabloleone\ArtisanUi\Models\Command;
use Illuminate\Routing\Controller as BaseController;
use Pabloleone\ArtisanUi\ArtisanUi;
use Illuminate\Support\Facades\Artisan as LaravelArtisan;
use Pabloleone\ArtisanUi\Http\Requests\Execute;

class Artisan extends BaseController {

    public function main()
    {
        $sections = (new ArtisanUi())->get();
        return view(
            'artisan-ui::themes.'.config('artisan-ui.theme').'.main',
            compact('sections')
        );
    }

    public function execute(Execute $request)
    {
        $command = $request->input('command');

        $artisanCommand = new Command(LaravelArtisan::all()[$command]);

        $artisanCommandArguments = $artisanCommand->getArguments();

        $arguments = collect($request->input('arguments'))->map(function ($value, $key) use ($artisanCommandArguments) {
            $finalValue = $value;
            foreach ($artisanCommandArguments as $argument) {
                if ($argument->getName() === $key && $argument->isArray()) {
                    $finalValue = explode(',', $value);
                }
            }
            return $finalValue;
        });

        $artisanCommandOptions = $artisanCommand->getOptions();

        $options = collect($request->input('options'))->map(function ($value, $key) use ($artisanCommandOptions) {
            $finalValue = $value;
            foreach ($artisanCommandOptions as $option) {
                if ($option->getName() === $key && $option->isArray()) {
                    $finalValue = explode(',', $value);
                }
            }
            return $finalValue;
        })->mapWithKeys(function ($value, $key) use ($request) {
            return (strpos($key, '--') === false) ? ['--'.$key => $value] : [$key => $value];
        });

        $parameters = $arguments->merge($options)->filter(function ($value) {
            return !is_null($value);
        });

        $exitCode = '';
        $output = '';

        try {
            event(new BeforeExecuteArtisanCommand($command, $parameters->toArray()));
            $exitCode = LaravelArtisan::call($command, $parameters->toArray());
            $output = LaravelArtisan::output();
        } catch (\RuntimeException $e) {
            $output = $e->getMessage();
            $exitCode = '1';
        } finally {
            event(new AfterExecuteArtisanCommand($exitCode, $output));
        }

        $sections = (new ArtisanUi())->get();

        return view(
            'artisan-ui::themes.'.config('artisan-ui.theme').'.main',
            compact('exitCode', 'output', 'sections')
        );
    }

}

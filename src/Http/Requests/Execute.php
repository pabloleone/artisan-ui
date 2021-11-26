<?php

namespace Pabloleone\ArtisanUi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Pabloleone\ArtisanUi\Rules\ValidCommand;
use Pabloleone\ArtisanUi\Rules\ValidCommandParameters;
use Illuminate\Support\Facades\Artisan;
use Pabloleone\ArtisanUi\Models\Command;

class Execute extends FormRequest
{
    private array $artisanCommands;

    public function __construct()
    {
        $this->artisanCommands = Artisan::all();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'command' => ['required', 'string', new ValidCommand],
            'arguments' => [
                'array',
                new ValidCommandParameters($this->getAvailableArguments($this->request->get('command')))
            ],
            'options' => [
                'array',
                new ValidCommandParameters($this->getAvailableOptions($this->request->get('command')))
            ],
        ];
    }

    private function getAvailableArguments($command): array
    {
        $validArguments = [];
        if (isset($this->artisanCommands[$command])) {
            $command = new Command($this->artisanCommands[$command]);
            if ($command) {
                $validArguments = collect($command->getArguments())->keys()->toArray();
            }
        }
        return $validArguments;
    }

    private function getAvailableOptions($command): array
    {
        $validOptions = [];
        if (isset($this->artisanCommands[$command])) {
            $command = new Command($this->artisanCommands[$command]);
            if ($command) {
                $validOptions = collect($command->getOptions())->keys()->toArray();
            }
        }
        return $validOptions;
    }
}

<?php

namespace Pabloleone\ArtisanUi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Pabloleone\ArtisanUi\Rules\ValidCommand;
use Pabloleone\ArtisanUi\Rules\ValidCommandParameters;
use Pabloleone\ArtisanUi\Models\Command;
use Pabloleone\ArtisanUi\ArtisanUi;

class Execute extends FormRequest
{
    public array $artisanCommands;

    public function __construct(ArtisanUi $artisanUi)
    {
        $this->artisanCommands = $artisanUi->getAvailableCommands()->toArray();
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
            'command' => ['required', 'string', new ValidCommand($this->artisanCommands)],
            'arguments' => [
                'array',
                new ValidCommandParameters(
                    $this->getAvailableArguments($this->request->get('command'))
                )
            ],
            'options' => [
                'array',
                new ValidCommandParameters(
                    $this->getAvailableOptions($this->request->get('command'))
                )
            ],
        ];
    }

    private function getAvailableArguments(string $commandId): array
    {
        $validArguments = [];
        if (isset($this->artisanCommands[$commandId])) {
            $command = new Command();
            $command->setCommand($this->artisanCommands[$commandId]);
            $validArguments = collect($command->getArguments())->keys()->toArray();
        }
        return $validArguments;
    }

    private function getAvailableOptions(string $commandId): array
    {
        $validOptions = [];
        if (isset($this->artisanCommands[$commandId])) {
            $command = new Command();
            $command->setCommand($this->artisanCommands[$commandId]);
            $validOptions = collect($command->getOptions())->keys()->toArray();
        }
        return $validOptions;
    }

    public function getParsedParametersFromRequest(
        ?array $parameters,
        ?array $availableParameters
    ): Collection {
        return collect($parameters)->map(function ($value, $key) use ($availableParameters) {
            $finalValue = $value;
            foreach ($availableParameters as $argument) {
                if ($argument->getName() === $key && $argument->isArray()) {
                    $finalValue = explode(',', $value);
                }
            }
            return $finalValue;
        });
    }

    public function getParameters(string $commandId, ?array $arguments, ?array $options): Collection
    {
        $command = new Command();
        $command->setCommand($this->artisanCommands[$commandId]);

        $commandArguments = $command->getArguments();

        $arguments = $this->getParsedParametersFromRequest($arguments, $commandArguments);

        $commandOptions = $command->getOptions();

        $options = $this->getParsedParametersFromRequest($options, $commandOptions)
            ->mapWithKeys(function ($value, $key) {
                return (strpos($key, '--') === false) ? ['--'.$key => $value] : [$key => $value];
            });

        return $arguments->merge($options)->filter(function ($value) {
            return !is_null($value);
        });
    }
}

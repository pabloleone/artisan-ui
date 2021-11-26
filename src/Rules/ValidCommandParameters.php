<?php

namespace Pabloleone\ArtisanUi\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCommandParameters implements Rule
{
    private array $validParameters;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $validParameters)
    {
        $this->validParameters = $validParameters;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validParameters = $this->validParameters;
        $invalidParameters = collect($value)->filter(function ($value, $key) use ($validParameters) {
            return !in_array($key, $validParameters);
        });

        return (empty($invalidParameters->toArray()));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('artisan-ui::validation.invalidParameters');
    }
}

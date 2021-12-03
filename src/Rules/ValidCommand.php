<?php

namespace Pabloleone\ArtisanUi\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCommand implements Rule
{
    private array $artisanCommmands;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $artisanCommmands)
    {
        $this->artisanCommmands = $artisanCommmands;
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
        return in_array($value, collect($this->artisanCommmands)->keys()->toArray());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('artisan-ui::validation.invalidCommand');
    }
}

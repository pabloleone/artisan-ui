<?php

namespace Pabloleone\ArtisanUi\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Artisan;

class ValidCommand implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return in_array($value, collect(Artisan::all())->keys()->toArray());
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

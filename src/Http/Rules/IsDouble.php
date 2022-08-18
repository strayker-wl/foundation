<?php

namespace Strayker\Foundation\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsDouble implements Rule
{
    public function passes($attribute, $value)
    {
        return is_float($value) || is_int($value);
    }

    public function message()
    {
        return 'Должен быть float';
    }
}

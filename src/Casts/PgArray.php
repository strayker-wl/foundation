<?php

namespace Strayker\Foundation\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PgArray implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?array
    {
        return json_decode(str_replace(['{', '}'], ['[', ']'], $value));
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        return str_replace(['[', ']'], ['{', '}'], json_encode($value));
    }
}

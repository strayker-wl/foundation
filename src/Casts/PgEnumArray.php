<?php

namespace Strayker\Foundation\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PgEnumArray implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?array
    {
        if (is_null($value)) {
            return null;
        }

        return array_map(
            fn($element) => trim($element, " \t\n\r\0\x0B\"{}"),
            explode(',', $value)
        );
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return '{' . implode(',', $value) . '}';
    }
}

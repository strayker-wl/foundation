<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Support\Str;

trait UsesUuid
{
    /**
     * Boot model events handlers for generate uuid
     *
     * @return void
     */
    protected static function bootUsesUuid(): void
    {
        static::creating(
            function ($model) {
                if (!$model->getKey()) {
                    $model->{$model->getKeyName()} = (string) Str::uuid();
                }
            }
        );

        static::saving(
            function ($model) {
                if (!$model->getKey()) {
                    $model->{$model->getKeyName()} = (string) Str::uuid();
                }
            }
        );
    }

    /**
     * Disable autoincrement for primary key
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Set type of primary key
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}

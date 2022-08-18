<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Support\Str;

trait GenerateDefaultSlugValue
{
    /**
     * Default slug key
     *
     * @var string
     */
    protected string $slugKey = 'code';

    /**
     * Default name key
     *
     * @var string
     */
    protected string $nameKey = 'name';

    /**
     * Get slug key
     *
     * @return string
     */
    protected function getSlugKey(): string
    {
        return $this->slugKey;
    }

    /**
     * Get key with entity name for slug generation
     *
     * @return string
     */
    protected function getNameKey(): string
    {
        return $this->nameKey;
    }

    /**
     * Boot model events handlers for generate slug/code from title or name
     *
     * @return void
     */
    public static function bootDefaultSlugValue(): void
    {
        static::creating(function ($model) {
            $model->{$this->getSlugKey()} = $model->{$this->getSlugKey()}
                ?? ($model->{$this->getNameKey()}
                    ? Str::slug($model->{$this->getNameKey()})
                    : null);
        });

        static::saving(function ($model) {
            $model->{$this->getSlugKey()} = $model->{$this->getSlugKey()}
                ?? ($model->{$this->getNameKey()}
                    ? Str::slug($model->{$this->getNameKey()})
                    : null);
        });
    }
}

<?php

namespace Strayker\Foundation\Factories;

use Strayker\Foundation\Contracts\Models\AbstractModelContract;
use Strayker\Foundation\Traits\ModelNameResolver;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModelFactory extends Factory
{
    use ModelNameResolver;

    /**
     * Get a new model instance.
     *
     * @param array $attributes
     * @return AbstractModelContract|Model
     */
    public function newModel(array $attributes = []): AbstractModelContract|Model
    {
        return app($this->modelName())->newInstance($attributes);
    }

    /**
     * Get the name of the model that is generated by the factory.
     *
     * @return string
     */
    public function modelName(): string
    {
        return $this->resolveModelName($this->model);
    }
}
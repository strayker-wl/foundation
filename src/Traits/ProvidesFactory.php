<?php

namespace Strayker\Foundation\Traits;

use Strayker\Foundation\Contracts\Models\AbstractModelContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

trait ProvidesFactory
{
    protected function createWithFactory(
        string $factoryClass,
        array  $data = [],
        int    $amount = null
    ): Collection|AbstractModelContract|Model {
        return $this->factory($factoryClass, $amount)->create($data);
    }

    protected function makeWithFactory(
        string $factoryClass,
        array  $data = [],
        int    $amount = null
    ): Collection|AbstractModelContract|Model {
        return $this->factory($factoryClass, $amount)->make($data);
    }

    private function factory(string $factoryClass, ?int $amount = null): Factory
    {
        /** @var Factory $factory */
        $factory = app($factoryClass);

        if (is_int($amount)) {
            return $factory->times($amount);
        }

        return $factory;
    }
}

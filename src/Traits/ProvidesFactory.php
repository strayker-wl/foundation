<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Strayker\Foundation\Contracts\Models\AbstractModelContract;

trait ProvidesFactory
{
    /**
     * @param string   $factoryClass
     * @param array    $data
     * @param int|null $amount
     * @return Collection|AbstractModelContract|Model
     */
    protected function createWithFactory(
        string $factoryClass,
        array  $data = [],
        int    $amount = null
    ): Collection|AbstractModelContract|Model {
        return $this->factory($factoryClass, $amount)->create($data);
    }

    /**
     * @param string   $factoryClass
     * @param array    $data
     * @param int|null $amount
     * @return Collection|AbstractModelContract|Model
     */
    protected function makeWithFactory(
        string $factoryClass,
        array  $data = [],
        int    $amount = null
    ): Collection|AbstractModelContract|Model {
        return $this->factory($factoryClass, $amount)->make($data);
    }

    /**
     * @param string   $factoryClass
     * @param int|null $amount
     * @return Factory
     */
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

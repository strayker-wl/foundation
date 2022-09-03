<?php

namespace Strayker\Foundation\Repositories;

use Illuminate\Database\Eloquent\Model;
use Strayker\Foundation\Contracts\Models\AbstractEloquentModelContract;
use Strayker\Foundation\Contracts\Repositories\AbstractEloquentRepositoryContract;

abstract class AbstractEloquentRepository extends AbstractRepository implements AbstractEloquentRepositoryContract
{
    /**
     * Instance of model
     *
     * @var AbstractEloquentModelContract|Model $model
     */
    protected AbstractEloquentModelContract|Model $model;

    /**
     * @param AbstractEloquentModelContract|Model $model
     */
    public function __construct(AbstractEloquentModelContract|Model $model)
    {
        $this->model = $model;
    }
}

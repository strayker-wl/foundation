<?php

namespace Strayker\Foundation\Services;

use Strayker\Foundation\Contracts\Repositories\AbstractEloquentRepositoryContract;
use Strayker\Foundation\Contracts\Services\AbstractEloquentServiceContract;

abstract class AbstractEloquentService extends AbstractService implements AbstractEloquentServiceContract
{
    /**
     * Repository instance
     *
     * @var AbstractEloquentRepositoryContract
     */
    protected AbstractEloquentRepositoryContract $repository;

    public function __construct(AbstractEloquentRepositoryContract $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }
}

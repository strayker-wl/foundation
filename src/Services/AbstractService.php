<?php

namespace Strayker\Foundation\Services;

use Strayker\Foundation\Contracts\Services\AbstractServiceContract;
use Strayker\Foundation\Traits\BootTraits;

abstract class AbstractService implements AbstractServiceContract
{
    use BootTraits;

    public function __construct()
    {
        $this->bootTraits();
    }
}

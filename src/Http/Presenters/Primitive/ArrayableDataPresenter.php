<?php

namespace Strayker\Foundation\Http\Presenters\Primitive;

use Strayker\Foundation\Http\Presenters\AbstractPresenter;

class ArrayableDataPresenter extends AbstractPresenter
{
    protected function resolve(): void
    {
        $this->data = $this->resource->toArray();
    }
}

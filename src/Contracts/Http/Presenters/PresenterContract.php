<?php

namespace Strayker\Foundation\Contracts\Http\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;

interface PresenterContract extends Arrayable, Jsonable, \JsonSerializable, Responsable
{
    /**
     * Set http code for response
     *
     * @param int|null $httpCode
     *
     * @return void
     */
    public function setHttpCode(?int $httpCode = null): void;

    /**
     * Get http code
     *
     * @return int
     */
    public function getHttpCode(): int;

    /**
     * Resolve data
     *
     * @return mixed
     */
    public function getData(): mixed;
}

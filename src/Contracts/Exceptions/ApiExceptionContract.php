<?php

namespace Strayker\Foundation\Contracts\Exceptions;

use Strayker\Foundation\Exceptions\Basic\ClassNotExists;

interface ApiExceptionContract extends ExceptionContract
{
    /**
     * Set presenter class name
     * If not class not set, on resolve will be used default presenter
     *
     * @param string $presenter
     * @return $this
     * @throws ClassNotExists
     */
    public function setPresenter(string $presenter): static;

    /**
     * Get presenter class name
     *
     * @return string
     */
    public function getPresenter(): string;

    /**
     * Render exception as api response
     *
     * @return mixed
     */
    public function render(): mixed;
}

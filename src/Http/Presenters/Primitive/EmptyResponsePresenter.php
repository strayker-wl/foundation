<?php

namespace Strayker\Foundation\Http\Presenters\Primitive;

use Strayker\Foundation\Http\Presenters\AbstractPresenter;
use Symfony\Component\HttpFoundation\Response;

class EmptyResponsePresenter extends AbstractPresenter
{
    public function __construct(int $httpCode = 204)
    {
        parent::__construct(null, $httpCode);
    }

    protected function resolve(): void
    {
        $this->data = null;
    }

    public function toResponse($request): Response
    {
        return new Response(status: $this->getHttpCode());
    }
}

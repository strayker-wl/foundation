<?php

namespace Strayker\Foundation\Exceptions\Basic;

use Strayker\Foundation\Exceptions\ApiException;

class EndpointNotFound extends ApiException
{
    protected const DEFAULT_EXCEPTION_NAME = 'endpoint_not_found';
    protected const DEFAULT_EXCEPTION_REASON = 'Эндпоинт не существует';
    protected const DEFAULT_EXCEPTION_CODE = 404;
}

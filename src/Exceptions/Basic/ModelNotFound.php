<?php

namespace Strayker\Foundation\Exceptions\Basic;

use Strayker\Foundation\Exceptions\ApiException;

class ModelNotFound extends ApiException
{
    protected const DEFAULT_EXCEPTION_NAME = 'model_not_found';
    protected const DEFAULT_EXCEPTION_REASON = 'Запись не существует';
    protected const DEFAULT_EXCEPTION_CODE = 404;
}

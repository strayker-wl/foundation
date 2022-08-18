<?php

namespace Strayker\Foundation\Exceptions\Models;

use Strayker\Foundation\Exceptions\ApiException;

class JsonEncodingError extends ApiException
{
    protected const DEFAULT_EXCEPTION_CODE = 'json_encoding_error';
    protected const DEFAULT_EXCEPTION_REASON = 'Внутренняя ошибка';
    protected const DEFAULT_EXCEPTION_HTTP_CODE = 500;
}

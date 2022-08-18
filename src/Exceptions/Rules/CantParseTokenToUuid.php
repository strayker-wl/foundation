<?php

namespace Strayker\Foundation\Exceptions\Rules;

use Strayker\Foundation\Exceptions\ApiException;

class CantParseTokenToUuid extends ApiException
{
    protected const DEFAULT_EXCEPTION_CODE = 'cant_parse_token_to_uuid';
    protected const DEFAULT_EXCEPTION_REASON = 'Невозможно преобразовать токен в uuid';
    protected const DEFAULT_EXCEPTION_HTTP_CODE = 500;
}

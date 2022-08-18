<?php

namespace Strayker\Foundation\Exceptions;

use Strayker\Foundation\Http\Presenters\Exceptions\ValidationExceptionPresenter;

class ValidationException extends ApiException
{
    protected const DEFAULT_EXCEPTION_CODE = 'validation_error';
    protected const DEFAULT_EXCEPTION_REASON = 'Данные не прошли проверку';
    protected const DEFAULT_EXCEPTION_HTTP_CODE = 400;
    protected const DEFAULT_PRESENTER = ValidationExceptionPresenter::class;
}

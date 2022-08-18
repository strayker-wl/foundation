<?php

namespace Strayker\Foundation\Exceptions\Tests;

use Strayker\Foundation\Exceptions\Exception;

class TransactionFailException extends Exception
{
    protected const DEFAULT_EXCEPTION_NAME = 'transaction_fail';
    protected const DEFAULT_EXCEPTION_REASON = 'Транзакция не применилась';
    protected const DEFAULT_EXCEPTION_CODE = 500;
}

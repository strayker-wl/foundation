<?php

namespace Strayker\Foundation\Exceptions\Basic;

use Strayker\Foundation\Exceptions\Exception;

class ClassNotExists extends Exception
{
    protected const DEFAULT_EXCEPTION_CODE = 'class_not_exists';
}

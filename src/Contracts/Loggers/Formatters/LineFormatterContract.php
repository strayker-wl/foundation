<?php

namespace Strayker\Foundation\Contracts\Loggers\Formatters;

interface LineFormatterContract
{
    public const FORMAT = "[%datetime%] %level_name%: %message% - %context%\n";
    public const DATE_FORMAT = 'Y-m-d\TH:i:s.uP';
}

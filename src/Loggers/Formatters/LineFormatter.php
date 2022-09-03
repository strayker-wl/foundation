<?php

namespace Strayker\Foundation\Loggers\Formatters;

use Monolog\Formatter\LineFormatter as MonologLineFormatter;
use Strayker\Foundation\Contracts\Loggers\Formatters\LineFormatterContract;
use Throwable;

class LineFormatter extends MonologLineFormatter implements LineFormatterContract
{
    /**
     * @param string|null $format
     * @param string|null $dateFormat
     * @param bool        $allowInlineLineBreaks
     * @param bool        $ignoreEmptyContextAndExtra
     */
    public function __construct(
        ?string $format = null,
        ?string $dateFormat = null,
        bool    $allowInlineLineBreaks = false,
        bool    $ignoreEmptyContextAndExtra = false,
    ) {
        parent::__construct(
            $format ?? self::FORMAT,
            $dateFormat ?? self::DATE_FORMAT,
            $allowInlineLineBreaks,
            $ignoreEmptyContextAndExtra,
        );
    }

    /**
     * Transform exception data to string
     *
     * @param Throwable $e
     * @param int       $depth
     * @return string
     */
    protected function normalizeException(Throwable $e, int $depth = 0): string
    {
        if (method_exists($e, '__toString')) {
            /** @var null|scalar|array<array|scalar|null> $value */
            return $e->__toString();
        }

        return parent::normalizeException($e, $depth);
    }
}

<?php

use Monolog\Handler\StreamHandler;
use Strayker\Foundation\Loggers\Formatters;

return [
    'channels' => [
        'stack' => [
            'formatter' => Formatters\LineFormatter::class,
            'formatter_with' => [
                'format' => (string) env('DEFAULT_LOG_FORMAT', Formatters\LineFormatter::FORMAT),
                'dateFormat' => (string) env('DEFAULT_LOG_TIME_FORMAT', Formatters\LineFormatter::DATE_FORMAT),
            ],
        ],
        'single' => [
            'formatter' => Formatters\LineFormatter::class,
            'formatter_with' => [
                'format' => (string) env('DEFAULT_LOG_FORMAT', Formatters\LineFormatter::FORMAT),
                'dateFormat' => (string) env('DEFAULT_LOG_TIME_FORMAT', Formatters\LineFormatter::DATE_FORMAT),
            ],
        ],
        'monolog-stdout' => [
            'driver' => 'monolog',
            'level' => (string) env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout',
            ],
            'formatter' => Formatters\LineFormatter::class,
            'formatter_with' => [
                'format' => (string) env('DEFAULT_LOG_FORMAT', Formatters\LineFormatter::FORMAT),
                'dateFormat' => (string) env('DEFAULT_LOG_TIME_FORMAT', Formatters\LineFormatter::DATE_FORMAT),
            ],
        ],
    ],
    'log_exception_stacktrace' => (bool) env('LOG_EXCEPTION_STACKTRACE', true),
];

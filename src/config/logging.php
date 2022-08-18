<?php

use Strayker\Foundation\Loggers\Formatters;
use Monolog\Handler\StreamHandler;

return [
    'channels' => [
        'stack' => [
            'level' => (string) env('APP_LOG_LEVEL', 'info'),
            'formatter' => Formatters\LineFormatter::class,
            'formatter_with' => [
                'format' => (string) env('DEFAULT_LOG_FORMAT', Formatters\LineFormatter::FORMAT),
                'dateFormat' => (string) env('DEFAULT_LOG_TIME_FORMAT', Formatters\LineFormatter::DATE_FORMAT),
            ],
        ],
        'single' => [
            'level' => (string) env('APP_LOG_LEVEL', 'info'),
            'formatter' => Formatters\LineFormatter::class,
            'formatter_with' => [
                'format' => (string) env('DEFAULT_LOG_FORMAT', Formatters\LineFormatter::FORMAT),
                'dateFormat' => (string) env('DEFAULT_LOG_TIME_FORMAT', Formatters\LineFormatter::DATE_FORMAT),
            ],
        ],
        'monolog-stdout' => [
            'driver' => 'monolog',
            'level' => (string) env('APP_LOG_LEVEL', 'info'),
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

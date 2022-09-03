<?php

namespace Strayker\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Strayker\Foundation\Traits\RecursiveConfigMerge;

class LoggingServiceProvider extends ServiceProvider
{
    use RecursiveConfigMerge;

    /**
     * Конфигурация логирования
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register(): void
    {
        $this->recursiveMergeConfigFrom(
            __DIR__ . '/../config/logging.php',
            'logging'
        );
    }
}

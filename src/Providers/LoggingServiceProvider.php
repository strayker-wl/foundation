<?php

namespace Strayker\Foundation\Providers;

use Strayker\Foundation\Traits\RecursiveConfigMerge;
use Illuminate\Support\ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
    use RecursiveConfigMerge;

    /**
     * Bootstrap the application services.
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

<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\CachesConfiguration;

trait RecursiveConfigMerge
{
    /**
     * Provide recursive merger for replace nested parameters
     *
     * @param string $path
     * @param string $key
     * @throws BindingResolutionException
     */
    protected function recursiveMergeConfigFrom(string $path, string $key): void
    {
        if (!($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $config = $this->app->make('config');

            $config->set($key, array_merge_recursive(
                require $path, $config->get($key, [])
            ));
        }
    }
}

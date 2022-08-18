<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Support\Str;

trait ModelNameResolver
{
    /**
     * Get model contract or class by factory name
     *
     * @param string $modelClass
     * @return string
     */
    public function resolveModelName(string $modelClass): string
    {
        $resolver = static::$modelNameResolver ?: function (self $factory): string {
            $factoryBasename = Str::replaceLast('Factory', '', class_basename($factory));

            $appNamespace = static::appNamespace();

            if (interface_exists($appNamespace . 'Contracts\Models\\' . $factoryBasename)) {
                return $appNamespace . 'Contracts\Models\\' . $factoryBasename;
            }

            return class_exists($appNamespace . 'Models\\' . $factoryBasename)
                ? $appNamespace . 'Models\\' . $factoryBasename
                : $appNamespace . $factoryBasename;
        };

        return $modelClass ?: $resolver($this);
    }
}

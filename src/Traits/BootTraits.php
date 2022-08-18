<?php

namespace Strayker\Foundation\Traits;

trait BootTraits
{
    protected static bool $booted = false;

    /**
     * Boot traits by call methods named as bootTraitName
     */
    public function bootTraits(): void
    {
        if (static::$booted) {
            return;
        }

        $class = $this::class;

        $booted = [];

        foreach (class_uses_recursive($class) as $trait) {
            $method = 'boot' . class_basename($trait);

            if (method_exists($class, $method) && !in_array($method, $booted)) {
                $this->{$method}();

                $booted[] = $method;
            }
        }

        static::$booted = true;
    }
}

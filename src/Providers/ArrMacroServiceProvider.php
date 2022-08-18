<?php

namespace Strayker\Foundation\Providers;

use Strayker\Foundation\Contracts\Enums\SortFunctionEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class ArrMacroServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->mergeOnNullMacro();
        $this->sortRecursiveMacro();
        $this->filterListMacro();
        $this->keyByMacro();
    }

    /**
     * @return void
     */
    private function mergeOnNullMacro(): void
    {
        Arr::macro(
            'mergeOnNull',
            function (array $primaryArray, array ...$secondaryArrays): array {
                foreach ($secondaryArrays as $secondaryArray) {
                    foreach ($secondaryArray as $key => $value) {
                        if (!isset($primaryArray[$key])) {
                            $primaryArray[$key] = $value;
                        }
                    }
                }

                return $primaryArray;
            }
        );
    }

    private function sortRecursiveMacro(): void
    {
        Arr::macro(
            'sortRecursive',
            function (array &$array, string $function = SortFunctionEnum::KSORT, ?callable $callback = null): void {
                foreach ($array as &$item) {
                    if (is_array($item)) {
                        Arr::sortRecursive($item, $function, $callback);
                    }
                }

                if (
                    $function === SortFunctionEnum::UASORT
                    || $function === SortFunctionEnum::UKSORT
                    || $function === SortFunctionEnum::USORT
                ) {
                    $function($array, $callback);
                } else {
                    $function($array);
                }
            }
        );
    }

    private function filterListMacro(): void
    {
        Arr::macro(
            'filterList',
            fn(array $items): array => array_unique(
                array_filter(
                    $items,
                    fn(int|string|null $item): bool => !is_null($item)
                )
            )
        );
    }

    private function keyByMacro(): void
    {
        Arr::macro(
            'keyBy',
            function (array $data, callable|string $keyField): array {
                $keyed = [];
                $isCallable = !is_string($keyField) && is_callable($keyField);

                foreach ($data as $key => $item) {
                    if ($isCallable) {
                        $finalKey = $keyField($item);
                    } elseif (isset($item[$keyField])) {
                        $finalKey = $item[$keyField];
                        if (!(is_string($finalKey) || is_int($finalKey))) {
                            $finalKey = (string) $finalKey;
                        }
                    } else {
                        $finalKey = $key;
                    }

                    $keyed[$finalKey] = $item;
                }

                return $keyed;
            }
        );
    }
}

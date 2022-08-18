<?php

namespace Strayker\Foundation\Http\Presenters\Exceptions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class ValidationExceptionPresenter extends ApiExceptionPresenter
{
    protected function resolve(): void
    {
        $this->setBasicExceptionData();

        if (!empty($this->resource['payload'])) {
            $errorBag = [];

            if (
                is_string($this->resource['payload']) ||
                is_numeric($this->resource['payload']) ||
                is_bool($this->resource['payload'])
            ) {
                $errorBag[] = $this->resource['payload'];
            } elseif (is_array($this->resource['payload']) || $this->resource['payload'] instanceof \ArrayAccess) {
                $this->mergeErrors($this->resource['payload'], $errorBag);
            } elseif ($this->resource['payload'] instanceof Arrayable) {
                $this->mergeErrors($this->resource['payload']->toArray(), $errorBag);
            } elseif ($this->resource['payload'] instanceof Jsonable) {
                $this->mergeErrors(json_decode($this->resource['payload']->toJson(), true), $errorBag);
            } elseif (is_object($this->resource['payload'])) {
                $errorData = var_export($this->resource['payload'], true);
                $this->mergeErrors((array) $errorData, $errorBag);
            } else {
                $this->mergeErrors((array) $this->resource['payload'], $errorBag);
            }

            $this->data['errors'] = $errorBag;
        }
    }

    /**
     * Merge errors
     *
     * @param array $errorsData
     * @param array $errorBag
     */
    private function mergeErrors(array $errorsData, array &$errorBag): void
    {
        $errorBag = array_merge($errorBag, array_values($errorsData));
    }
}

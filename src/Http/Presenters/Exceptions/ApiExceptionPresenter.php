<?php

namespace Strayker\Foundation\Http\Presenters\Exceptions;

use Illuminate\Support\Arr;
use Strayker\Foundation\Http\Presenters\AbstractPresenter;

class ApiExceptionPresenter extends AbstractPresenter
{
    protected function resolve(): void
    {
        $this->setBasicExceptionData();

        if (!empty($this->resource['payload'])) {
            if ($this->resource['wrap_payload']) {
                $this->data['payload'] = $this->resource['payload'];
            } else {
                $this->data = array_merge(
                    $this->data,
                    Arr::except(
                        $this->resource['payload'],
                        [
                            'error_code',
                            'error_reason',
                            'error_description',
                        ]
                    )
                );
            }
        }
    }

    protected function setBasicExceptionData(): void
    {
        $this->data = [
            'error_code' => $this->resource['code'] ?? 'internal_error',
            'error_reason' => $this->resource['reason'] ?? 'Внутренняя ошибка',
        ];

        if (!empty($this->resource['description'])) {
            $this->data['error_description'] = $this->resource['description'];
        }
    }
}

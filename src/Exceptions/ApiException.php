<?php

namespace Strayker\Foundation\Exceptions;

use Strayker\Foundation\Contracts\Exceptions\ApiExceptionContract;
use Strayker\Foundation\Exceptions\Basic\ClassNotExists;
use Strayker\Foundation\Http\Presenters\Exceptions\ApiExceptionPresenter;

class ApiException extends Exception implements ApiExceptionContract
{
    /**
     * Default presenter for render api response with error messages
     */
    protected const DEFAULT_PRESENTER = ApiExceptionPresenter::class;

    /**
     * If true - payload will be wrap into 'payload' object in root of response (response.payload)
     * If false - payload will be merged into root of response
     */
    protected const WRAP_PAYLOAD = false;

    /**
     * Presenter for render response
     *
     * @var string
     */
    protected string $presenter;

    /**
     * @inheritDoc
     */
    public function setPresenter(string $presenter): static
    {
        if (class_exists($presenter)) {
            $this->presenter = $presenter;

            return $this;
        }

        throw new ClassNotExists([
            'presenter' => $presenter,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getPresenter(): string
    {
        if (empty($this->presenter)) {
            $this->presenter = static::DEFAULT_PRESENTER;
        }

        return $this->presenter;
    }

    /**
     * @inheritDoc
     */
    public function render(): mixed
    {
        $class = $this->getPresenter();
        return new $class([
            'code' => $this->getExceptionCode(),
            'reason' => $this->getReason(),
            'description' => $this->getDescription(),
            'payload' => $this->getPayload(),
            'wrap_payload' => static::WRAP_PAYLOAD,
        ], $this->getHttpCode());
    }
}

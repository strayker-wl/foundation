<?php

namespace Strayker\Foundation\Exceptions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Strayker\Foundation\Contracts\Exceptions\ExceptionContract;
use Throwable;

class Exception extends \Exception implements ExceptionContract
{
    /**
     * Default name of exception for transfer to \Exception as string message
     * Can be used for log or error response identification
     */
    protected const DEFAULT_EXCEPTION_CODE = 'internal_error';

    /**
     * Default reason of exception
     */
    protected const DEFAULT_EXCEPTION_REASON = 'Внутренняя ошибка';

    /**
     * Default description of exception
     */
    protected const DEFAULT_EXCEPTION_DESCRIPTION = '';

    /**
     * Default http code for response
     */
    protected const DEFAULT_EXCEPTION_HTTP_CODE = 500;

    /**
     * @var array|object|bool|string|int|float|null context for logger
     */
    protected array|object|bool|string|int|float|null $context;

    /**
     * @var string reason for presenter
     */
    protected string $reason;

    /**
     * @var string description for presenter
     */
    protected string $description;

    /**
     * @var array|null payload for presenter
     */
    protected array|null $payload;

    /**
     * @var int http code for response
     */
    protected int $httpCode;

    /**
     * @param array|object|bool|string|int|float|null $context
     * @param string|null                             $reason
     * @param string|null                             $description
     * @param array|null                              $payload
     * @param int|null                                $httpCode
     * @param Throwable|null                          $previous
     */
    public function __construct(
        array|object|bool|string|int|float|null $context = null,
        string|null                             $reason = null,
        string|null                             $description = null,
        array|null                              $payload = null,
        int|null                                $httpCode = null,
        Throwable|null                          $previous = null
    ) {
        $this
            ->setContext($context)
            ->setReason($reason)
            ->setDescription($description)
            ->setPayload($payload)
            ->setHttpCode($httpCode);

        parent::__construct(
            $this->getReason(),
            $this->getHttpCode(),
            $previous
        );
    }

    /**
     * @inheritDoc
     */
    public function setContext(array|object|bool|string|int|float|null $context = null): static
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setReason(string|null $reason = null): static
    {
        $this->reason = empty($reason) ? static::DEFAULT_EXCEPTION_REASON : $reason;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string|null $description = null): static
    {
        $this->description = empty($description) ? static::DEFAULT_EXCEPTION_DESCRIPTION : $description;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPayload(array|null $payload = null): static
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setHttpCode(int|null $httpCode = null): static
    {
        $this->httpCode = empty($httpCode) ? static::DEFAULT_EXCEPTION_HTTP_CODE : $httpCode;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getContext(): array|object|bool|string|int|float|null
    {
        return $this->context;
    }

    /**
     * @inheritDoc
     */
    public function getExceptionCode(): string
    {
        return static::DEFAULT_EXCEPTION_CODE;
    }

    /**
     * @inheritDoc
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getPayload(): array|null
    {
        return $this->payload;
    }

    /**
     * @inheritDoc
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Prepare context for logger
     *
     * @inheritDoc
     */
    public function __toString(): string
    {
        $context = $this->getContext();

        $errorMessage =
            '[class] ' . static::class . "\n"
            . '[code] ' . $this->getExceptionCode() . "\n"
            . '[reason] ' . $this->getReason() . "\n"
            . '[http_code] ' . $this->getHttpCode() . "\n"
            . '[payload] ' . var_export($this->getPayload(), true) . "\n"
            . '[context] ';
        if (is_string($context) || is_numeric($context)) {
            $errorMessage .= $context;
        } elseif ($context instanceof Arrayable) {
            $errorMessage .= var_export($context->toArray(), true);
        } elseif ($context instanceof Jsonable) {
            $errorMessage .= $context->toJson();
        } else {
            $errorMessage .= var_export($context, true);
        }

        $errorMessage .= "\n[file] " . $this->getFile() . "\n"
            . '[line] ' . $this->getLine();

        if (config('logging.log_exception_stacktrace', true)) {
            $errorMessage .= "\n[stacktrace]\n" . $this->getTraceAsString();
        }

        return $errorMessage;
    }
}

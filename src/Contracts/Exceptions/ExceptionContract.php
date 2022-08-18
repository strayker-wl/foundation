<?php

namespace Strayker\Foundation\Contracts\Exceptions;

use Stringable;

interface ExceptionContract extends Stringable
{
    /**
     * Set exception context for logger
     *
     * @param array|object|bool|string|int|float|null $context
     * @return static
     */
    public function setContext(array|object|bool|string|int|float|null $context = null): static;

    /**
     * Set exception reason for presenter
     *
     * @param string|null $reason
     * @return \Strayker\Foundation\Exceptions\Exception
     */
    public function setReason(string|null $reason = null): static;

    /**
     * Set exception description for presenter
     *
     * @param string|null $description
     * @return \Strayker\Foundation\Exceptions\Exception
     */
    public function setDescription(string|null $description = null): static;

    /**
     * Set exception payload for presenter
     *
     * @param array|null $payload
     * @return static
     */
    public function setPayload(array|null $payload = null): static;

    /**
     * Set http code for response
     *
     * @param int|null $httpCode
     * @return static
     */
    public function setHttpCode(int|null $httpCode = null): static;

    /**
     * Get exception context
     *
     * @return array|object|bool|string|int|float|null
     */
    public function getContext(): array|object|bool|string|int|float|null;

    /**
     * Get exception symbolic code
     *
     * @return string
     */
    public function getExceptionCode(): string;

    /**
     * Get exception reason
     *
     * @return string
     */
    public function getReason(): string;

    /**
     * Get exception description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get exception payload
     *
     * @return array|null
     */
    public function getPayload(): array|null;

    /**
     * Get http code
     *
     * @return int
     */
    public function getHttpCode(): int;
}

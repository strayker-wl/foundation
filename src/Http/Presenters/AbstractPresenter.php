<?php

namespace Strayker\Foundation\Http\Presenters;

use Strayker\Foundation\Contracts\Http\Presenters\PresenterContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;

abstract class AbstractPresenter implements PresenterContract
{
    /**
     * Contain data to be returned with response
     *
     * @var mixed $data
     */
    protected mixed $data;

    /**
     * Contain data provided by the controller
     *
     * @var mixed $resource
     */
    protected mixed $resource;

    /**
     * Custom http code for response
     *
     * @var int $httpCode
     */
    protected int $httpCode = 200;

    /**
     * Wrapper tag for response
     * If don't need wrap data - set null
     *
     * @var string|null
     */
    protected ?string $wrapper = null;

    /**
     * Resolver which will process $resource with specific rules and pass result to the $data
     *
     * @return void
     */
    abstract protected function resolve(): void;

    /**
     * @param mixed    $resource
     * @param int|null $httpCode
     */
    public function __construct(mixed $resource, ?int $httpCode = null)
    {
        $this->resource = $resource;
        $this->setHttpCode($httpCode);
    }

    /**
     * Set http code for response
     *
     * @param int|null $httpCode
     *
     * @return void
     */
    public function setHttpCode(?int $httpCode = null): void
    {
        if ($httpCode) {
            $this->httpCode = $httpCode;
        } elseif (!empty($this->resource['http_code'])) {
            $this->httpCode = $this->resource['http_code'];
            unset($this->resource['http_code']);
        } elseif (!empty($this->resource['httpCode'])) {
            $this->httpCode = $this->resource['httpCode'];
            unset($this->resource['httpCode']);
        }
    }

    /**
     * Get http code
     *
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode ?: 200;
    }

    /**
     * Resolve data
     *
     * @return mixed
     */
    public function getData(): mixed
    {
        if (empty($this->data)) {
            $this->resolve();
        }
        return $this->data;
    }

    /**
     * Get wrapper tag
     *
     * @return null|string
     */
    protected function getWrapperKey(): ?string
    {
        return $this->wrapper;
    }

    /**
     * Wrap data with tag, if tag is not null
     *
     * @param array|\ArrayAccess $data
     * @return array|\ArrayAccess
     */
    protected function wrap(array|\ArrayAccess $data): array|\ArrayAccess
    {
        if (!($key = $this->getWrapperKey())) {
            return $data;
        }

        if (count($data) == 1 && array_key_exists($key, $data)) {
            return $data;
        }

        return [$key => $data];
    }

    /**
     * Transform data to array
     *
     * @return array|\ArrayAccess
     */
    public function toArray(): array|\ArrayAccess
    {
        $data = $this->getData();

        if ($data instanceof Arrayable) {
            return $data->toArray();
        } elseif ($data instanceof \ArrayAccess) {
            return $data;
        } elseif ($data instanceof Jsonable) {
            return json_decode($data->toJson(), true);
        } else {
            return (array) $data;
        }
    }

    /**
     * Transform data to json
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Transform data to serializable
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->wrap($this->toArray());
    }

    /**
     * Prepare response object
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse($this->wrap($this->toArray()), $this->getHttpCode());
    }
}

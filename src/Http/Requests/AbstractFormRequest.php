<?php

namespace Strayker\Foundation\Http\Requests;

use Strayker\Foundation\Exceptions\ValidationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Validation\Validator;

class AbstractFormRequest extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    /**
     * Container instance
     *
     * @var Container
     */
    protected Container $container;

    /**
     * Key to be used for the view error bag
     *
     * @var string
     */
    protected string $errorBag = 'default';

    /**
     * Validator instance
     *
     * @var Validator
     */
    protected Validator $validator;

    /**
     * Set the container instance
     *
     * @param Container $container
     * @return void
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    /**
     * Determine if the request passes the authorization check.
     *
     * @return bool
     */
    protected function passesAuthorization(): bool
    {
        if (method_exists($this, 'authorize')) {
            return $this->container->call([$this, 'authorize']);
        }

        return true;
    }

    /**
     * Get the validator instance
     *
     * @return Validator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function validator(): Validator
    {
        if (isset($this->validator)) {
            return $this->validator;
        }

        $factory = $this->container->make(ValidationFactory::class);

        $this->setValidator($factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']),
            $this->messages(), $this->attributes()
        ));

        return $this->validator;
    }

    /**
     * Set the validator instance
     *
     * @param Validator $validator
     * @return void
     */
    public function setValidator(Validator $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData(): array
    {
        return $this->all();
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validated(): array
    {
        return $this->validator->validated();
    }

    /**
     * Get custom messages for validator errors
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException(payload: $validator->errors()->messages());
    }

    /**
     * Get route parameter by route key
     *
     * @param string $key
     * @param mixed  $defaultValue
     * @return mixed
     */
    public function getRouteParameter(string $key, mixed $defaultValue = null): mixed
    {
        return Arr::first($this->route(), fn($element) => isset($element[$key]))[$key] ?? $defaultValue;
    }
}

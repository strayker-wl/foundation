<?php

namespace Strayker\Foundation\Providers;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider;
use Strayker\Foundation\Http\Requests\AbstractFormRequest;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Регистрация валидатора
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(AbstractFormRequest::class, function ($request, $app) {
            $request = AbstractFormRequest::createFrom($app['request'], $request);
            $request->setContainer($app);
        });
    }
}

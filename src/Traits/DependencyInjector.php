<?php

namespace Strayker\Foundation\Traits;

trait DependencyInjector
{
    private function bindClass(
        string $contract,
        string $class,
        array  $parameters = [],
        bool   $isSingleton = false
    ): void {
        $method = $isSingleton ? 'singleton' : 'bind';
        $this->app->$method(
            $contract,
            fn() => $this->app->make($class, $parameters)
        );
    }

    /**
     * @param string $repositoryContract
     * @param string $repository
     * @param string $modelContract
     * @param bool   $isSingleton
     * @return void
     */
    private function bindEloquentRepository(
        string $repositoryContract,
        string $repository,
        string $modelContract,
        bool   $isSingleton = false
    ): void {
        $this->bindClass(
            $repositoryContract,
            $repository,
            [
                'model' => $this->app->make($modelContract),
            ],
            $isSingleton
        );
    }

    /**
     * @param string $serviceContract
     * @param string $service
     * @param string $repositoryContract
     * @param bool   $isSingleton
     * @return void
     */
    private function bindEloquentService(
        string $serviceContract,
        string $service,
        string $repositoryContract,
        bool   $isSingleton = false
    ): void {
        $this->bindClass(
            $serviceContract,
            $service,
            [
                'repository' => $this->app->make($repositoryContract),
            ],
            $isSingleton
        );
    }
}

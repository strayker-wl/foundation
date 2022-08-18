<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Support\Arr;

trait ParametersReplacer
{
    /**
     * Заменяет параметры вида {name} на переданные значения в массиве вида ['name' => 'test']
     *
     * @param string   $str
     * @param array    $parameters
     * @param string[] $templates          список найденных в строке параметров
     * @param string[] $notFoundParameters список параметров для которых не найдено значений
     * @param bool     $removeNotFounded   удалять не найденные параметры из строки
     * @return string
     */
    protected function replaceParameters(
        string $str,
        array  $parameters = [],
        array  &$templates = [],
        array  &$notFoundParameters = [],
        bool   $removeNotFounded = false
    ): string {
        return $this->replaceParametersByPattern(
            $str,
            '/\{(.*?)\}/',
            $parameters,
            $templates,
            $notFoundParameters,
            $removeNotFounded
        );
    }

    /**
     * Заменяет параметры вида {name} на переданные значения в массиве вида ['name' => 'test']
     * поддерживает вложенные конструкции
     *
     * @param string   $str
     * @param array    $parameters
     * @param string[] $templates          список найденных в строке параметров
     * @param string[] $notFoundParameters список параметров для которых не найдено значений
     * @param bool     $removeNotFounded   удалять не найденные параметры из строки
     * @return string
     */
    protected function replaceParametersWithNestedSupport(
        string $str,
        array  $parameters = [],
        array  &$templates = [],
        array  &$notFoundParameters = [],
        bool   $removeNotFounded = false
    ): string {
        return $this->replaceParametersByPattern(
            $str,
            '/\{([a-z]+?)\}/i',
            $parameters,
            $templates,
            $notFoundParameters,
            $removeNotFounded
        );
    }

    /**
     * Заменяет параметры на переданные значения в массиве вида ['name' => 'test'] по заданному паттерну
     *
     * @param string   $str
     * @param string   $pattern
     * @param array    $parameters
     * @param string[] $templates          список найденных в строке параметров
     * @param string[] $notFoundParameters список параметров для которых не найдено значений
     * @param bool     $removeNotFounded   удалять не найденные параметры из строки
     * @return string
     */
    protected function replaceParametersByPattern(
        string $str,
        string $pattern,
        array  $parameters = [],
        array  &$templates = [],
        array  &$notFoundParameters = [],
        bool   $removeNotFounded = false
    ): string {
        return preg_replace_callback(
            $pattern,
            function (array $paramName) use (
                $parameters,
                &$templates,
                &$notFoundParameters,
                $removeNotFounded
            ): string {
                $templates[] = $paramName[0];
                if (isset($parameters[$paramName[1]])) {
                    return Arr::pull($parameters, $paramName[1]);
                } else {
                    $notFoundParameters[] = $paramName[0];
                    return $removeNotFounded ? '' : $paramName[0];
                }
            },
            $str
        );
    }
}

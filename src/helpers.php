<?php

if (!function_exists('get_class_const_values')) {
    function get_class_const_values(string $className, int $filter = ReflectionClassConstant::IS_PUBLIC): array
    {
        return array_values((new ReflectionClass($className))->getConstants($filter));
    }
}

if (!function_exists('get_values_list_from_env')) {
    function get_values_list_from_env(string $envKey, string $default = '', string $separator = ','): array
    {
        return empty($list = env($envKey, $default))
            ? []
            : array_unique(array_map(
                fn($item) => trim($item),
                explode($separator, $list)
            ));
    }
}

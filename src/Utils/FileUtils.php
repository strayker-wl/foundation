<?php

namespace Strayker\Foundation\Utils;

use Illuminate\Support\Str;

class FileUtils
{
    /**
     * Получить список всех файлов в дирректории, включая поддирректории
     *
     * @param string $path
     * @return array
     */
    public static function getFilesList(string $path): array
    {
        $path = realpath($path);
        $resultList = [];

        if (empty($path) || !is_dir($path)) {
            return [];
        }

        foreach (array_diff(scandir($path), ['.', '..']) as $newPath) {
            $fullPath = $path . '/' . $newPath;
            if (is_dir($fullPath)) {
                $resultList = array_merge($resultList, static::getFilesList($fullPath));
            } else {
                $resultList[] = $fullPath;
            }
        }

        return $resultList;
    }

    /**
     * Получить полные имена класса с неймспейсами из списка файлов
     *
     * @param array $files
     * @return array
     */
    public static function getClasses(array $files): array
    {
        $rootNamespace = app()->getNamespace();
        $rootDir = app()->path() . DIRECTORY_SEPARATOR;
        $namespaces = [];

        foreach ($files as $file) {
            $namespaces[] = $rootNamespace
                . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($file, $rootDir)
                );
        }

        return $namespaces;
    }

    /**
     * Получить полные имена класса с неймспейсами в дирректории, включая поддирректории
     *
     * @param string $path
     * @return array
     */
    public static function getClassesFromDirectory(string $path): array
    {
        return static::getClasses(static::getFilesList($path));
    }
}

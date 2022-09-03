<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Support\Str;
use Strayker\Foundation\Exceptions\Rules\CantParseTokenToUuid;

trait UniqueTokenFormer
{
    /**
     * Получить уникальный токен
     *
     * @param string|null $token
     * @param int         $length
     * @return string
     */
    protected function getUniqueToken(?string $token = null, int $length = 32): string
    {
        if (empty($token)) {
            $token = Str::random($length);
        } else {
            $token = preg_replace('/[^a-z\d]+/i', '', $token);
            $strLen = strlen($token);
            if ($token < $length) {
                $token .= Str::random($length - $strLen);
            } elseif ($strLen > $length) {
                $token = substr($token, 0, $length);
            }
        }

        return $token;
    }

    /**
     * Получить уникальный токен из uuid
     *
     * @param string|null $uuid
     * @return string
     */
    protected function getUniqueTokenFromUuid(?string $uuid = null): string
    {
        if (empty($uuid)) {
            $uuid = (string) Str::uuid();
        }

        return $this->getUniqueToken($uuid, 32);
    }

    /**
     * Преобразует уникальный токен в uuid
     *
     * @param string $token
     * @return string
     * @throws CantParseTokenToUuid
     */
    protected function restoreUuidFromUniqueToken(string $token): string
    {
        if (strlen($token) !== 32) {
            throw new CantParseTokenToUuid(['token' => $token]);
        }

        return substr($token, 0, 8)
            . '-'
            . substr($token, 8, 4)
            . '-'
            . substr($token, 12, 4)
            . '-'
            . substr($token, 16, 4)
            . '-'
            . substr($token, 20, 12);
    }
}

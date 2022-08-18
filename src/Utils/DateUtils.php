<?php

namespace Strayker\Foundation\Utils;

use Carbon\Carbon;

class DateUtils
{
    /**
     * Change timezone for input date
     * If $timezone = null , timezone not change
     * if $format = null , return Carbon\Carbon object
     *
     * @param string|Carbon $date
     * @param string|null   $timezone
     * @param string|null   $format
     * @return string|Carbon
     */
    public static function changeTimezone(
        string|Carbon $date,
        ?string       $timezone = '+03:00',
        ?string       $format = 'Y-m-d H:i:s'
    ): string|Carbon {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        if (!empty($timezone)) {
            $date = $date->timezone($timezone);
        }

        if (empty($format)) {
            return $date;
        }

        return $date->format($format);
    }
}

<?php

namespace Strayker\Foundation\Traits;

use Carbon\CarbonImmutable;
use Closure;
use DateTimeInterface;
use Illuminate\Support\Carbon;

trait DateSerializer
{
    /**
     * Default date format for all dates when model serialized for toArray() or toJson() methods
     * If not set, use ISO-8601 format as default
     *
     * @var string|Closure|null
     */
    protected static string|Closure|null $defaultSerializeDateFormat = null;

    /**
     * Date format for all dates when model serialized for toArray() or toJson() methods
     * If not set, use ISO-8601 format as default
     *
     * @var string|Closure|null
     */
    protected static string|Closure|null $serializeDateFormat;

    /**
     * If true, keep timezone for all dates when model serialized for toArray() or toJson() methods
     *
     * @var bool
     */
    protected bool $keepTimezone = true;

    /**
     * @return void
     */
    protected static function bootDateSerializer(): void
    {
        static::$serializeDateFormat = static::$defaultSerializeDateFormat;
    }

    /**
     * Set flag for keep timezone when model serialized for toArray() or toJson() methods
     *
     * @return $this
     */
    public function keepTimezone(): static
    {
        $this->keepTimezone = true;

        return $this;
    }

    /**
     * Set flag for not keep timezone when model serialized for toArray() or toJson() methods
     *
     * @return $this
     */
    public function notKeepTimezone(): static
    {
        $this->keepTimezone = false;

        return $this;
    }

    /**
     * Get current flag value for date serializer
     *
     * @return bool
     */
    public function isTimezoneKept(): bool
    {
        return $this->keepTimezone;
    }

    /**
     * Serializable model will use specified format
     *
     * @param string|Closure $format
     * @return $this
     */
    public function withDateFormat(string|Closure $format): static
    {
        static::$serializeDateFormat = $format;

        return $this;
    }

    /**
     * Serializable model will use default format
     *
     * @return $this
     */
    public function withDefaultDateFormat(): static
    {
        static::$serializeDateFormat = static::$defaultSerializeDateFormat;

        return $this;
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param DateTimeInterface $date
     * @return string|null
     */
    protected function serializeDate(DateTimeInterface $date): ?string
    {
        if (!empty(static::$serializeDateFormat)) {
            if (is_callable(static::$serializeDateFormat)) {
                return (static::$serializeDateFormat)($date);
            }

            return $date->format(static::$serializeDateFormat);
        }

        if ($this->isTimezoneKept()) {
            return $date instanceof \DateTimeImmutable ?
                CarbonImmutable::instance($date)->toISOString(true) :
                Carbon::instance($date)->toISOString(true);
        }

        return $date instanceof \DateTimeImmutable ?
            CarbonImmutable::instance($date)->toJSON() :
            Carbon::instance($date)->toJSON();
    }
}

<?php

namespace Strayker\Foundation\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDefaultScopes
{
    /**
     * Check is active
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}

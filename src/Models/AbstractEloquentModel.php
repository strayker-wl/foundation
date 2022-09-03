<?php

namespace Strayker\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use Strayker\Foundation\Contracts\Models\AbstractEloquentModelContract;
use Strayker\Foundation\Traits\DateSerializer;

abstract class AbstractEloquentModel extends Model implements AbstractEloquentModelContract
{
    use DateSerializer;

    public $preventsLazyLoading = true;
}

<?php

namespace Strayker\Foundation\Models;

use Strayker\Foundation\Contracts\Models\AbstractEloquentModelContract;
use Strayker\Foundation\Traits\DateSerializer;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquentModel extends Model implements AbstractEloquentModelContract
{
    use DateSerializer;

    public $preventsLazyLoading = true;
}

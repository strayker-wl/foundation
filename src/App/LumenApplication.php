<?php

namespace Strayker\Foundation\App;

use Laravel\Lumen\Application as BaseLumenApplication;

class LumenApplication extends BaseLumenApplication
{
    public function bootstrapRouter(): void
    {
        $this->router = new LumenRouter($this);
    }
}

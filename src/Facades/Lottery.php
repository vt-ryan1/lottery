<?php

namespace Victtech\Lottery\Facades;

use Illuminate\Support\Facades\Facade;

class Lottery extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'lottery';
    }
}

<?php

namespace Victtech\Lottery\Facades;

use Illuminate\Support\Facades\Facade;

class PersonLottery extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'personLottery';
    }
}

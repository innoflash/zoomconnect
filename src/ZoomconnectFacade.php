<?php

namespace Innoflash\Zoomconnect;

use Illuminate\Support\Facades\Facade;

class ZoomconnectFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'zoomconnect';
    }
}
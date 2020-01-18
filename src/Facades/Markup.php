<?php

namespace Veloxia\Markup\Facades;

use Illuminate\Support\Facades\Facade;

class Markup extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'markup';
    }
}

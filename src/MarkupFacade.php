<?php

namespace Veloxia\Markup;

use Illuminate\Support\Facades\Facade;

class MarkupFacade extends Facade
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

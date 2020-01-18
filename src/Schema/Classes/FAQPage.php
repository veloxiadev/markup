<?php

namespace Veloxia\Markup\Schema\Classes;

use Veloxia\Markup\Schema\BaseClass;

class FAQPage extends BaseClass
{
    public function mainEntity($mainEntity)
    {
        return $this->pushAttribute('mainEntity', $mainEntity);
    }
}

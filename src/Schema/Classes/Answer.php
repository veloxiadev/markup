<?php

namespace Veloxia\Markup\Schema\Classes;

use Veloxia\Markup\Schema\BaseClass;

class Answer extends BaseClass
{
    public function text(string $text)
    {
        return $this->setAttribute('text', $text);
    }

    public function answer(string $answer)
    {
        return $this->text($answer);
    }
}

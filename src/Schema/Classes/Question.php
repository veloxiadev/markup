<?php

namespace Veloxia\Markup\Schema\Classes;

use Veloxia\Markup\Schema\BaseClass;

class Question extends BaseClass
{
    /**
     * The accepted answer of the question.
     *
     * @param string|\Veloxia\Markup\Schema\Answer $acceptedAnswer
     * @return void
     */
    public function acceptedAnswer($acceptedAnswer)
    {
        return $this->setAttribute('acceptedAnswer', $acceptedAnswer);
    }

    public function name(string $name)
    {
        return $this->setAttribute("name", $name);
    }
}

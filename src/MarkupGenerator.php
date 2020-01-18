<?php

namespace Veloxia\Markup;

class MarkupGenerator
{

    /**
     * The model that is being created.
     */
    public $model;

    /**
     * Attributes that await a subsequent call to be filled.
     */
    private $danglingItems = [];

    /**
     * Returns the Class as an array.
     *
     * @return void
     */
    public function dumpCurrentState()
    {
        return (array) $this->model;
    }

    /**
     * Set an item that should be returned on the next call to $this->getDanglingItem()
     *
     * @param string $label
     * @param mixed $object
     * @return void
     */
    protected function setDanglingItem($label, $object)
    {
        $this->danglingItems[$label] = $object;
    }

    /**
     * Gets the dangling item.
     *
     * @param string $label
     * @return void
     */
    protected function getDanglingItem($label)
    {
        $temp = $this->danglingItems[$label];
        unset($this->danglingItems[$label]);
        return $temp;
    }
}

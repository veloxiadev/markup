<?php

namespace Veloxia\Markup\Schema;

/**
 * This is the wrapper class for all structured data classes.
 */
abstract class BaseClass
{

    /**
     * The context.
     */
    public $_context = "https://schema.org";

    /**
     * Sets up the class with the correct "@type"
     */
    public function __construct()
    {
        $path = explode('\\', get_called_class());
        $this->_type = array_pop($path);
    }

    /**
     * Sets an attribute of the class that extends this class. 
     *
     * @param string $attribute
     * @param mixed $value
     */
    protected function setAttribute(string $attribute, $value)
    {
        $this->$attribute = $value;
        return $this;
    }

    /**
     * Pushes an item to the $attribute array. 
     *
     * @param string $attribute
     * @param mixed $value
     */
    protected function pushAttribute(string $attribute, $value)
    {
        // check if the variable exists, if not create array
        if (!isset($this->$attribute)) {
            $this->$attribute = [];
        }

        // it might exist but not as an array... 
        // for now let's allow this, might need to throw something
        else if (!is_array($this->$attribute)) {
            $this->$attribute = [$this->$attribute];
        }

        // push and return
        array_push($this->$attribute, $value);
        return $this;
    }

    /**
     * Sets relationships.
     */
    public function belongsTo($owner)
    {
        $this->belongsTo = $owner;
    }

    /**
     * Returns the class as an array.
     *
     * @return array
     */
    public function dumpModel()
    {
        return $this;
    }
}

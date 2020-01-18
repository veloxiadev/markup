<?php

namespace Veloxia\Markup;

use Veloxia\Markup\Markup;
use Illuminate\Support\Collection;

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
     * Dump the model as an array.
     *
     * @return object
     */
    public function dump()
    {
        $array = (array) $this->model;
        $array = $this->replaceKeysRecursive($array);
        return $array;
    }

    /**
     * Get the generated data as "application/ld+json"  
     *
     * @return string
     */
    public function json($dontReturnScriptTag = false): string
    {
        $array = (array) $this->model;
        $array = $this->replaceKeysRecursive($array);

        // set formatting.
        if (Markup::getConfig('pretty_json')) {
            $format = \JSON_PRETTY_PRINT;
        } else {
            $format = 0;
        }

        // encode
        $json = json_encode($array, $format);

        // create tag
        if (!$dontReturnScriptTag) {
            $json =
                '<script type="application/ld+json">' .
                "\n" . $json . "\n" .
                '</script>';
        }

        return $json;
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

    protected function replaceKeysRecursive($input)
    {
        $output = [];
        foreach ($input as $key => $value) {
            $newKey = preg_replace('/[^_]*_/', '@', $key);
            $output[$newKey] = (is_array($value) || is_object($value)) ? $this->replaceKeysRecursive($value) : $value;
        }
        return $output;
    }
}

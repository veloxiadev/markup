<?php

namespace Veloxia\Markup;

use Veloxia\Markup\Exception\UnknownMarkupSchemaException;

class Markup
{

    /**
     * The markup handler instance.
     *
     * @var mixed
     */
    protected $handler;

    /**
     * Constructs the markup class.
     */
    public function __construct()
    {
    }

    /**
     * Create a new data model. 
     *
     * @param string $type
     * @return self
     */
    public function make($type): self
    {
        $model = "\\Veloxia\\Markup\\Generators\\" . $type;

        if (!class_exists($model)) {
            throw new UnknownMarkupSchemaException('Could not find a controller for the requested markup.');
        }

        $this->handler = new $model;

        return $this;
    }

    /**
     * Dump the Array output of the generated class.
     *
     * @return array
     */
    public function dump(): array
    {
        return $this->handler->dumpCurrentState();
    }

    /**
     * Magic method to catch all calls and forward to the correct handler.
     */
    public function __call($name, $arguments)
    {
        $response = $this->handler->$name(...$arguments);
        return $response;
    }
}

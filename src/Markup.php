<?php

namespace Veloxia\Markup;

use Veloxia\Markup\Exception\UnknownMarkupSchemaException;

/**
 * This class is the "router" class that direct calls to the correct generator.
 */
class Markup
{

    /**
     * The markup handler instance.
     */
    protected $handler;

    /**
     * Config.
     */
    public static $config = [];

    /**
     * Constructs the markup class.
     */
    public function __construct($config = [])
    {
        self::$config = $config;
    }

    public static function getConfig($key)
    {
        return @self::$config[$key] ?: null;
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
     * Magic method to catch all calls and forward to the correct handler.
     */
    public function __call($name, $arguments)
    {
        $response = $this->handler->$name(...$arguments);
        return $response;
    }
}

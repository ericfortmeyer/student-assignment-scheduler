<?php

namespace StudentAssignmentScheduler\Rules;

use \Ds\Map;
use \Traversable;

/**
 * Contains key value pairs of subjects tested by 'Rules'
 */
final class Context implements \ArrayAccess
{
    /**
     * @var Map The container
     */
    private $container;

    /**
     * Uses either an array or Traversable object
     * 
     * @param Traversable|array $values
     */
    public function __construct($values)
    {
        $this->validateArgs($values);

        $this->container = new Map($values);

    }
    protected function validateArgs($args)
    {
        $invalid = !(is_a($args, Traversable::class) || is_array($args));

        if ($invalid) {
            throw new \InvalidArgumentException(
                "Value must be an array or traversable object"
            );
        }
    }

    public function offsetExists($offset): bool
    {
        return key_exists($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->container[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}

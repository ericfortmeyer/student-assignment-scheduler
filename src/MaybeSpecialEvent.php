<?php declare(strict_types=1);

namespace StudentAssignmentScheduler;

/**
 * Represents the result of either finding or not finding a SpecialEvent.
 *
 */
final class MaybeSpecialEvent
{
    /**
     * @var SpecialEvent|mixed $value
     */
    private $value;

    /**
     * @var mixed
     */
    private $callable_result;
    
    private function __construct($possibly_a_special_event)
    {
        $this->value = $possibly_a_special_event;
    }

    private function __clone()
    {
    }

    /**
     * Return a MaybeSpecialEvent instance.
     *
     * @param SpecialEvent|mixed $possibly_a_special_event
     * @return self
     */
    public static function init($possibly_a_special_event): self
    {
        return new self($possibly_a_special_event);
    }

    /**
     * Returns a SpecialEvent instance or invokes the given function.
     *
     * @param \Closure $doIfEmpty
     * @return SpecialEvent|mixed
     */
    public function getOrElse(\Closure $doIfEmpty)
    {
        return $this->value instanceof SpecialEvent
            ? $this->value
            : $doIfEmpty();
    }

    /**
     * Performs given operation if this instance
     * contains the expected value.
     *
     * @param \Closure $callable
     * @return static
     */
    public function onSuccess(\Closure $callable): self
    {
        if ($this->value) {
            $this->callable_result = $callable($this->value);
        }

        return $this;
    }

    /**
     * Performs given operation if this instance
     * does not contain the expected value.
     *
     * @param \Closure $callable
     * @return static
     */
    public function onFailure(\Closure $callable): self
    {
        if (!$this->value) {
            $this->callable_result = $callable($this->value);
        }

        return $this;
    }

    /**
     * Return the result of onSuccess or onFailure.
     *
     * @return mixed
     */
    public function resolve()
    {
        return $this->callable_result;
    }
}

<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace jwvirtualassistant\AccountManagement;

/**
 * Represents classes that represent values.
 */
abstract class ValueType
{
    /**
     * The string that the type represents.
     *
     * @var string $value
     */
    protected $value = "";

    /**
     * Create the instance.
     *
     * @param string $value
     */
    public function __construct(string $value = "")
    {
        $this->validate($this->getValidator(), $value);
        $this->value = $value;
    }

    /**
     * Throw an exception if the value is invalid.
     *
     * @param \Closure $validator Function that returns true if the value is invalid
     * @param string $value
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function validate(\Closure $validator, string $value): void
    {
        [$isInvalid, $reason] = $validator($value);
        if ($isInvalid) {
            throw new \InvalidArgumentException(
                sprintf(
                    "%s is not a valid %s.  Reason: %s",
                    $value,
                    static::class,
                    $reason
                )
            );
        }
    }

    /**
     * Return the validator function.
     *
     * The function should return true if the value is invalid.
     * @return \Closure
     */
    abstract protected function getValidator(): \Closure;

    /**
     * Return the type as a string.
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * Return the type of the class as a normalized string.
     *
     * @return string
     */
    public function getType(): string
    {
        $splitAtNamespaceSeparator = explode("\\", \get_called_class());
        $justTheClassName = end($splitAtNamespaceSeparator);
        return \strtolower($justTheClassName);
    }
}

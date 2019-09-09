<?php declare(strict_types=1);

namespace StudentAssignmentScheduler;

/**
 * Represents the result of either finding or not finding a Contact.
 *
 */
final class MaybeContact
{
    /**
     * @var Contact|mixed $value
     */
    private $value;
    
    private function __construct($possibly_a_contact)
    {
        $this->value = $possibly_a_contact;
    }

    /**
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }

    /**
     * Return a MaybeContact instance.
     *
     * @param Contact|mixed $possibly_a_contact
     * @return self
     */
    public static function init($possibly_a_contact): self
    {
        return new self($possibly_a_contact);
    }

    /**
     * Returns a Contact instance or invokes the given function.
     *
     * @param \Closure $doIfEmpty
     * @return Contact|mixed
     */
    public function getOrElse(\Closure $doIfEmpty)
    {
        return $this->value instanceof Contact
            ? $this->value
            : $doIfEmpty();
    }
}

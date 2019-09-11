<?php declare(strict_types=1);

namespace StudentAssignmentScheduler;

/**
 * Collections and Entities that implement
 * this interface can be used in libraries
 * that require ArrayObject like methods.
 * For example, an API that returns a
 * json serialized representation of the
 * collection or entity.
 */
interface ArrayInterface
{
    /**
     * Return a copy of the entity as an array.
     *
     * @return array
     */
    public function getArrayCopy(): array;

    /**
     * Cast an array to the entity.
     *
     * @param mixed $array
     * @return array
     */
    public function exchangeArray($array): array;
}

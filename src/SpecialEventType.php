<?php

namespace StudentAssignmentScheduler;

use \Ds\Vector;

final class SpecialEventType
{
    private $type = "";

    /**
     * @throws InvalidSpecialEventTypeException
     */
    public function __construct(iterable $allowed_types, string $type)
    {
        $VectorOfAllowedTypes = new Vector($allowed_types);

        if (!$VectorOfAllowedTypes->contains($type)) {
            throw new InvalidSpecialEventTypeException(
                $type,
                SpecialEventType::class,
                \json_encode($allowed_types)
            );
        }

        $this->type = $type;
    }

    public function __toString()
    {
        return $this->type;
    }
}

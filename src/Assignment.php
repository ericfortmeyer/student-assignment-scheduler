<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
namespace StudentAssignmentScheduler;

/**
 * Represents information required to make an assignment.
 *
 * This instance does not represent an assignment
 * that has been made.
 */
final class Assignment
{
    /**
     * @var string $name Name of the assignment
     */
    public $name = "";

    /**
     * @var int $number The assignment number used in the schedule
     */
    public $number = 0;

    /**
     * @param string $number Will be converted to an int
     * @param string $name
     */
    public function __construct(string $number, string $name)
    {
        $this->number = (int) $number;
        $this->name = $name;
    }

    /**
     * Use to transform the instance into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->number,
            $this->name
        ];
    }

    /**
     * Use to cast the instance into a string.
     *
     * @return string The assignment name
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * The assignment number.
     *
     * @return int
     */
    public function number(): int
    {
        return $this->number;
    }
}

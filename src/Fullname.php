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
 * Represents a person's fullname.
 */
final class Fullname
{
    /**
     * @var string $fullname
     */
    private $fullname = "";

    /**
     * Creates a Fullname instance.
     *
     * Create with fullname as first argument or
     * First name as the first argument and last name as the second
     * argument.
     *
     * @param string $name Can be fullname or first name
     * @param string $last_name Use if first and last name are separate
     */
    public function __construct(string $name, string $last_name = "")
    {
        $this->fullname = $last_name ? ucwords($this->fullname($name, $last_name)) : ucwords($name);
    }

    /**
     * Creates a normalized fullname.
     *
     * @param string $first_name
     * @param string $last_name
     * @return string First and last name separated by a space
     */
    private function fullname(string $first_name, string $last_name): string
    {
        return "${first_name} ${last_name}";
    }

    /**
     * Use to cast the instance to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->fullname;
    }
}

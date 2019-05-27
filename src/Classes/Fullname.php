<?php

namespace StudentAssignmentScheduler\Classes;

final class Fullname
{
    /**
     * @var string $fullname
     */
    private $fullname = "";

    /**
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

    private function fullname(string $first_name, string $last_name): string
    {
        return "${first_name} ${last_name}";
    }

    public function __toString()
    {
        return $this->fullname;
    }
}

<?php

namespace StudentAssignmentScheduler\Exception;

class InvalidTableNameException extends \RuntimeException
{
    public function __construct(string $given_table_name, array $valid_table_names)
    {
        $validTableNamesAsString = join(", ", $valid_table_names);
        $this->message = "${given_table_name} is not a valid table name."
            . "  Valid table names are ${validTableNamesAsString}";
    }
}

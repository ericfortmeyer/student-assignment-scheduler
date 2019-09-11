<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;
use \InvalidArgumentException;

class InvalidArgumentExceptionTest extends TestCase
{
    public function testClassesThrowInvalidArgumentException()
    {
        $classCreatingFunctions = [
            function () {
                new Destination("not a directory");
            },
            function () {
                new Guid("invalid guid");
            },
        ];
        array_map(
            function (\Closure $create_class) {
                try {
                    $create_class();
                    $this->assertTrue(false);
                } catch (InvalidArgumentException $e) {
                    $this->assertTrue(true);
                }
            },
            $classCreatingFunctions
        );
    }
}

<?php

namespace StudentAssignmentScheduler\BackupAndRestore;

use PHPUnit\Framework\TestCase;

use \InvalidArgumentException;

class FileTest extends TestCase
{
    public function testThrowsInvalidArgumentExceptionIfFileDoesNotExist()
    {
        try {
            new File("nonexistent_file");
            $this->assertTrue(false); // test failed
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true); // test passed
        }
    }
}

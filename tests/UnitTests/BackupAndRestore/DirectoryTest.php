<?php

namespace StudentAssignmentScheduler\BackupAndRestore;

use PHPUnit\Framework\TestCase;

use \InvalidArgumentException;

class DirectoryTest extends TestCase
{
    public function testThrowsInvalidArgumentExceptionIfDirectoryDoesNotExist()
    {
        try {
            new Directory("nonexistent_directory");
            $this->assertTrue(false); // test failed
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(true); // test passed
        }
    }
}

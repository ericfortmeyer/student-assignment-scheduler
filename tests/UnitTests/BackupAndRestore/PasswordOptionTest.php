<?php

namespace StudentAssignmentScheduler\BackupAndRestore;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Password;

class PasswordOptionTest extends TestCase
{
    public function testPasswordOptionSelectsFirstClosureIfPasswordIsProvidedInConstructor()
    {
        $given_password = "some_fake_password";
        $first = function (Password $expected_password) use ($given_password) {
            $this->assertSame(
                $given_password,
                (string) $expected_password
            );
        };
        $second = function () {
            $this->assertTrue(false); // test failed
        };
        (new PasswordOption(new Password($given_password)))->select($first, $second);
    }

    public function testPasswordOptionSelectsSecondClosureIfPasswordIsNotProvidedInConstructor()
    {
        $first = function () {
            $this->assertTrue(false); // test failed
        };
        $second = function () {
            $this->assertTrue(true); // test passed
        };
        (new PasswordOption())->select($first, $second);
    }
}

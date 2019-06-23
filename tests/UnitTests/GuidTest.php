<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

class GuidTest extends TestCase
{
    public function testGuidIsValid()
    {
        $valid_guid_pattern = "/^[[:xdigit:]]{8}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{12}$/";
        
        $guid = new Guid();
        $guid_from_constructor_argument = "87654321-1234-4321-4132-987654321123";

        $this->assertRegExp(
            $valid_guid_pattern,
            $guid
        );

        $this->assertRegExp(
            $valid_guid_pattern,
            $guid_from_constructor_argument
        );
    }

    public function testInvalidGuidAsConstructorArgumentCausesAnExceptionToBeThrown()
    {
        try {
            new Guid("fail");
            $this->assertTrue(false);
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }
    }
}

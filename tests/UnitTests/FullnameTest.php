<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

class FullnameTest extends TestCase
{
    protected function setup(): void
    {
        $this->first_name = $first_name = "Bob";
        $this->last_name = $last_name = "Smith";
        $this->fullname = "${first_name} ${last_name}";
    }

    public function testReturnsFullnameWhenGivenOneArg()
    {

        $expected = "{$this->first_name} {$this->last_name}";

        $this->assertSame(
            $expected,
            (string) new Fullname($this->fullname)
        );
    }

    public function testReturnsFullnameWhenGivenTwoArgs()
    {
        $expected = "{$this->first_name} {$this->last_name}";

        $this->assertSame(
            $expected,
            (string) new Fullname($this->first_name, $this->last_name)
        );
    }

    public function testMiddleNameIsUpperCase()
    {
        $first_name = "Booker";
        $middle_name = "T";
        $last_name = "Washington";
        $firstNameWithMiddleName = "${first_name} ${middle_name}";
        $expected = "${firstNameWithMiddleName} ${last_name}";

        $this->assertSame(
            $expected,
            $test = (string) new Fullname("${firstNameWithMiddleName}", $last_name)
        );
    }
}

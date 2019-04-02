<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

class FullnameTest extends TestCase
{
    protected function setup()
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
}

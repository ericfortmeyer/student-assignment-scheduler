<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

class SpecialEventTypeTest extends TestCase
{
    protected function setup(): void
    {
        $this->allowed = [
            "Regional Convention",
            "Assembly",
            "Memorial",
            "CO Visit"
        ];
    }
    
    public function testCanBeCastToString()
    {
        $given = new SpecialEventType(
            $this->allowed,
            "Regional Convention"
        );

        $this->assertTrue(is_string((string) $given));
    }

    public function testWillConvertToExpectedString()
    {
        array_map(
            function (string $expected_result, string $result_of_casting_to_string) {
                $this->assertSame($expected_result, $result_of_casting_to_string);
            },
            $this->allowed,
            array_map(
                function (string $type): string {
                    return new SpecialEventType($this->allowed, $type);
                },
                $this->allowed
            )
        );
    }

    public function testThrowsInvalidSpecialEventTypeExpception()
    {
        try {
            new SpecialEventType($this->allowed, "i am not an allowed type");
        } catch (\Exception $e) {
            $this->assertTrue(is_a($e, InvalidSpecialEventTypeException::class));
        }
    }
}

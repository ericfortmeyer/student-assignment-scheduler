<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

use \DateTimeImmutable;
use \Ds\Vector;

class SpecialEventTest extends TestCase
{
    protected function setup(): void
    {
        $allowed = [
            "CO Visit",
            "Assembly",
            "Regional Convention",
            "Assembly"
        ];
        $this->given = new SpecialEvent(
            $this->given_date = new Date(
                $Month = new Month(1),
                new DayOfMonth($Month, 12),
                new Year(2058)
            ),
            $this->given_special_event_type = new SpecialEventType(
                $allowed,
                "CO Visit"
            )
        );

        $this->special_event_in_the_past = new SpecialEvent(
            new Date(
                $Month,
                new DayOfMonth($Month, 12),
                new Year(1958)
            ),
            new SpecialEventType(
                $allowed,
                "Assembly"
            )
        );

        $CurrentMonth = new Month((new DateTimeImmutable())->format("m"));
        $CurrentYear = new Year((new DateTimeImmutable())->format("Y"));
        
        $Today = new Date(
            $CurrentMonth,
            new DayOfMonth(
                $CurrentMonth,
                (new DateTimeImmutable("00:00"))->format("d")
            ),
            $CurrentYear
        );

        $Yesterday = $Today->sub(1);

        $this->special_event_in_the_recent_past = new SpecialEvent(
            $Yesterday,
            new SpecialEventType(
                $allowed,
                "Assembly"
            )
        );
    }

    public function testAccessorsReturnExpectedValues()
    {
        $this->assertInstanceOf(
            Date::class,
            $this->given->date()
        );

        $this->assertInstanceOf(
            SpecialEventType::class,
            $this->given->type()
        );

        $this->assertEquals(
            $this->given->date(),
            $this->given_date
        );

        $this->assertEquals(
            $this->given->type(),
            $this->given_special_event_type
        );

        $this->assertFalse(
            $this->given->isPast()
        );

        $this->assertTrue(
            $this->special_event_in_the_past->isPast()
        );

        $this->assertTrue(
            $this->special_event_in_the_recent_past->isPast()
        );
    }

    public function testWillCastToExpectedString()
    {
        $this->assertSame(
            "CO Visit:              20580112" . PHP_EOL,
            (string) $this->given
        );
    }
}

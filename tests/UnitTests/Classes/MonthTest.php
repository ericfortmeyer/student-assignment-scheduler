<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

use \Ds\Vector;

class MonthTest extends TestCase
{
    public function testMonthsAreSortable()
    {
        $months_before_sorting = (new Vector([4,2,1,3]))
            ->map(
                function (int $num): Month {
                    return new Month($num);
                }
            );

        $expected_after_sorting = [
            new Month(1),
            new Month(2),
            new Month(3),
            new Month(4),
        ];

        $months_after_sorting = $months_before_sorting->sorted(
            function (Month $a, Month $b): int {
                return $a <=> $b;
            }
        )->toArray();

        $this->assertTrue(
            $months_after_sorting == $expected_after_sorting
        );

        // check to avoid false positives
        $this->assertFalse(
            $months_after_sorting == $months_before_sorting
        );
    }
}

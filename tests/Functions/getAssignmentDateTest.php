<?php

namespace TalkSlipSender\Functions;

use PHPUnit\Framework\TestCase;

class GetAssignmentDateTest extends TestCase
{
    protected function setup()
    {
        $this->passes = [
            "{MONTH} 29–NOVEMBER 2",
            "{MONTH} 29–NOVEMBER 2",
            "{MONTH}       29–NOVEMBER 2",
            PHP_EOL . "{MONTH} 29",
            PHP_EOL . PHP_EOL . "{MONTH} 29–NOVEMBER 2",
            "N" . PHP_EOL . "{MONTH} 29–NOVEMBER 2"
        ];

        $this->fails = [
            " {MONTH} 29–NOVEMBER 2",
            "string{MONTH} 29–NOVEMBER 2",
            "3 {MONTH} 29–NOVEMBER 2",
            "3{MONTH} 29–NOVEMBER 2",
            "{MONTH} D29",
            "{MONTH}    d29",
            "{MONTH} \n29"
        ];

        $this->target_date = "02";

        $this->config = include __DIR__ . "/../../config/config.php";
    }

    protected function withPattern(string $search): string
    {

        return "/{$this->beginningOfLine()}$search{$this->horizontalWhitespace()}{$this->oneOrTwoDigits()}/m";
    }
    
    protected function beginningOfLine(): string
    {
        return "^";
    }

    protected function horizontalWhitespace(): string
    {
        return "\h+";
    }

    protected function oneOrTwoDigits(): string
    {
        return "(\d{1,2})";
    }

    public function testOnlyPassesIfMonthAndDayOfMonthIsAtBeginningOfLine()
    {
        $month = "October";
        $month_all_caps = \strtoupper($month);

        foreach ($this->passingTests($month_all_caps) as $test) {
            $this->assertThat(
                $test,
                $this->matchesRegularExpression(
                    $this->withPattern($month_all_caps)
                )
            );
        }

        foreach ($this->failingTests($month_all_caps) as $test) {
            $this->assertThat(
                $test,
                $this->logicalNot(
                    $this->matchesRegularExpression(
                        $this->withPattern($month_all_caps)
                    )
                )
            );
        }
    }

    public function testPregSplitResult()
    {
        $month = "October";
        $month_all_caps = strtoupper($month);

        $this->assertCount(
            2,
            preg_split(
                $this->withPattern($month_all_caps),
                $this->passingTests($month_all_caps)[1]
            )
        );
    }

    public function testGetAssignmentDateFunctionWorks()
    {
        $month = "October";
        $month_all_caps = strtoupper($month);

        $target_date = "01";

        $meeting_night = $this->config["meeting_night"];
        $interval_spec_for_meeting_night = $this->config["interval_spec"][$meeting_night];
        
        
        foreach ($this->passingTests($month_all_caps) as $test) {
            $this->assertSame(
                $target_date,
                getAssignmentDate(
                    $test,
                    $month,
                    $interval_spec_for_meeting_night
                )
            );
        }
    }

    protected function passingTests(string $month): array
    {
        return array_map(
            function (\Closure $callable) use ($month) {
                return $callable($month);
            },
            array_map(
                [$this, "extrapolateMonth"],
                $this->passes
            )
        );
    }

    protected function failingTests(string $month): array
    {
        return array_map(
            function (\Closure $callable) use ($month) {
                    return $callable($month);
            },
            array_map(
                [$this, "extrapolateMonth"],
                $this->fails
            )
        );
    }

    protected function extrapolateMonth(string $string_to_change): \Closure
    {
        return function (string $month) use ($string_to_change): string {
            return strtr(
                $string_to_change,
                [
                    "{MONTH}" => $month
                ]
            );
        };
    }
}

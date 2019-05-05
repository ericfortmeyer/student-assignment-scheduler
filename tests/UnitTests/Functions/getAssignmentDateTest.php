<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

class GetAssignmentDateTest extends TestCase
{
    protected function setup(): void
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

    public function testDateParsingOfRtfFiles()
    {
        /**
         * should capture (1) the month and (2) the date
         * Rtf files have dates embedded in escaped encodings
         * \b February\u160?4-10
         * \b February\u160?25\u8122?March\u3
         *
         */

        $testCases = new \Ds\Vector([
            '\b February\u160?4-10',
            '\b February\u160?25\u8211?March',
            '\b January\u160?24\u8211?Feburary',
            '\b July\u160?3-7',
            '\b June\u160?30\u8211?July'
        ]);

        $testPattern = "/\\\\b\s{1}(\w{4,9})\\\\u160\?(\d{1,2})(?:-|\\\\u8211\?)(?:[\w]{4,9}|\d{1,2})/";
        
        $map = new \Ds\Map();

        $map->put($testCases[0], [$testCases[0], 'February', '4']);
        $map->put($testCases[1], [$testCases[1], 'February', '25']);        
        $map->put($testCases[2], [$testCases[2], 'January', '24']);        
        $map->put($testCases[3], [$testCases[3], 'July', '3']);        
        $map->put($testCases[4], [$testCases[4], 'June', '30']);        
        
        $runTests = function (string $test_case, array $expectedMatches) use ($testPattern): void {
            $this->assertThat(
                $test_case,
                $this->matchesRegularExpression($testPattern)
            );


            preg_match($testPattern, $test_case, $matches);
            $this->assertEquals(
                $expectedMatches,
                $matches
            );
        };

        $map->apply($runTests);
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

        $meeting_night = "Thursday";
        $pattern_config = $this->getPatternConfig();
        $interval_spec_for_meeting_night = $pattern_config["interval_spec"][$meeting_night];
        $pattern_func = $pattern_config["assignment_date_pattern_func"];
        
        
        foreach ($this->passingTests($month_all_caps) as $test) {
            $this->assertSame(
                $target_date,
                getAssignmentDate(
                    $pattern_func($month),
                    $test,
                    $month,
                    $interval_spec_for_meeting_night
                )
            );
        }
    }

    protected function getPatternConfig(): array
    {
        return require __DIR__ . "/../../../Utils/parse_config.php";
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

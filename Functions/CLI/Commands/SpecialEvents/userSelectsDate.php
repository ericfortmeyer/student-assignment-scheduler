<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\SpecialEvents;

use \Ds\{
    Vector,
    Map
};
use \DateTimeImmutable;

use StudentAssignmentScheduler\Classes\{
    Month,
    DayOfMonth,
    Year,
    Date,
    SpecialEvent,
    SpecialEventType,
    InvalidDateTypeArgumentException
};

use function StudentAssignmentScheduler\Functions\CLI\{
    prompt,
    yes,
    no,
    notYesOrNo,
    green
};

function userSelectsDate(SpecialEventType $EventType): SpecialEvent
{
    [$select_current_month_msg, $select_month_from_list, $select_day_of_month_msg, $select_year_msg] = [
        prompt("Is the special event this month"),
        "Which month is the special event in?"
            . PHP_EOL . "Please enter the number next to it: ",
        "What day of the month is the special event on: ",
        function (Year $year): string {
            return prompt("Is it in ${year}");
        }
    ];

    $Date = new Date(
        $Month = selectCurrentMonthOrFromListOfMonths(
            $select_current_month_msg,
            $select_month_from_list
        ),
        retryUntilUserSelectsValidDayOfMonth($Month, $select_day_of_month_msg),
        currentYearOrNextYear($select_year_msg)
    );

    return new SpecialEvent($Date, $EventType);
}

function selectCurrentMonthOrFromListOfMonths(string $message, string $select_from_list_message): Month
{
    $reply = readline($message);

    return yes($reply)
        ? new Month((new DateTimeImmutable())->format("m"))
        : (
            no($reply)
                ? (function (string $message, string $select_from_list_message): Month {
                    $listOfMonths = new Map();
                    $keysAsNumericValueOfMonth = function (int $month) use ($listOfMonths): void {
                        $listOfMonths->put($month, (new Month($month))->asText());
                    };

                    (new Vector(range(1, 12)))->apply($keysAsNumericValueOfMonth);
            
                    displayMonths($listOfMonths);

                try {
                    return new Month(
                        readline($select_from_list_message)
                    );
                } catch (InvalidDateTypeArgumentException $e) {
                    print $e->getMessage() . PHP_EOL;
                    print "Please try again" . PHP_EOL;

                    return selectCurrentMonthOrFromListOfMonths(
                        $message,
                        $select_from_list_message
                    );
                }
                })($message, $select_from_list_message)
                : (
                    notYesOrNo($reply)
                        ? selectCurrentMonthOrFromListOfMonths($message, $select_from_list_message)
                        // so static analyzer won't complain
                        : new Month((string) 1)
                )
            );
}

function displayMonths(Map $listOfMonths): void
{
    $listOfMonths->apply(
        function (int $key, string $month): void {
            print "(" . green("${key}") . ") ${month}" . PHP_EOL;
        }
    );
}

function retryUntilUserSelectsValidDayOfMonth(Month $Month, string $message): DayOfMonth
{
    try {
        return new DayOfMonth($Month, readline($message));
    } catch (InvalidDateTypeArgumentException $e) {
        print $e->getMessage() . PHP_EOL
            . "Please try again" . PHP_EOL;
        return retryUntilUserSelectsValidDayOfMonth($Month, $message);
    }
}

function currentYearOrNextYear(\Closure $messageFunc, ?Year $givenYear = null): Year
{
    $year = $givenYear ?? new Year((new DateTimeImmutable())->format("Y"));

    $reply = readline($messageFunc($year));

    return yes($reply)
        ? new Year($year)
        : (
            no($reply)
                ? currentYearOrNextYear($messageFunc, (new Year($year))->add(1))
                : (
                    notYesOrNo($reply)
                        ? currentYearOrNextYear($messageFunc, $year)
                        : new Year($year)
                )
        );
}

<?php

namespace TalkSlipSender\Functions;

use \Ds\Vector;

function monthsFromScheduleFilenames(string $path_to_json_schedules, bool $do_past_months = false): array
{
    $vector = new Vector(filenamesInDirectory($path_to_json_schedules));
    /**
     * Requires key "month" to simplify passing arguments into
     * sortMonths function for other clients
     */
    return $vector->map(function (string $filename) {
        return basename($filename, ".json");
    })->sorted(function (string $month_a, string $month_b) {
        return monthObj($month_a) <=> monthObj($month_b);
    })->filter(function (string $month) use ($do_past_months) {
        return !$do_past_months && !isPastMonth($month);
    })->map(function (string $month) {
        return ["month" => $month];
    })->toArray();
}

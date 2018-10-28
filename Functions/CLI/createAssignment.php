<?php

namespace TalkSlipSender\Functions\CLI;

function createAssignment(
    string $date,
    string $assignment,
    string $name,
    string $counsel_point,
    string $assistant
): array {
    $data = [
        "date" => $date,
        "assignment" => $assignment,
        "name" => ucfirst($name),
        "counsel_point" => $counsel_point,
        "assistant" => ucfirst($assistant)
    ];
    $heading = snakeCaseToUCWords($assignment);
    do {
        echo "\r\n",
            "Assignment: " . white($heading) . "\r\n",
            "Name: " . white($data["name"]) . "\r\n",
            $data["assistant"] ? "Assitant: " . white($data["assistant"]) . "\r\n" : "",
            "Counsel Point: " . white($data["counsel_point"]) . "\r\n",
            "Date: " . white($data["date"]) . "\r\n";
        $reply = readline(isItCorrectPrompt());

        if (yes($reply)) {
            return $data;
        } elseif (no($reply)) {
            return createAssignment(
                $date,
                $assignment,
                $name,
                $counsel_point,
                $assistant
            );
        } else {
            echo "Please enter yes or no\r\n";
        }
    } while (notYesOrNo($reply));

    /**
     * To suppress phan error since the function must return an array
     */
    return [];
}

<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function \StudentAssignmentScheduler\Functions\generateContactsFile;

use \Ds\Vector;
use \Ds\Set;

define(__NAMESPACE__ . "\QUIT_MESSAGE", "(type q for quit)");

function setupContacts(string $path_to_contacts_file, ?string $retry_message = null): void
{
    print $retry_message ? $retry_message . PHP_EOL : purple("Now setting up contacts") . PHP_EOL . PHP_EOL;

    $prompts = [
        "first_name" => "Enter first name",
        "last_name" => "Enter last name",
        "email_address" => "Enter email address"
    ];

    // use Set to prevent duplicates
    $contacts = new Set();

    $get_data_from_user = function (string $prompt, string $input_type): array {
        $tuple = exec("read -p '$prompt' input; echo \$input");
        print PHP_EOL;

        return $input_type === "email_address"
            ? [$tuple, filter_var($tuple, FILTER_VALIDATE_EMAIL)]
            : [$tuple, ucfirst($tuple)];
    };

    $display_result = function ($carry, string $contact): void {
        print green("-->") . " $contact" . PHP_EOL;
    };

    while (true) {
        $replies = new Vector();

        foreach ($prompts as $input_type => $prompt) {
            $prompt .= yellow(QUIT_MESSAGE) . ":  ";

            // user's response
            $tuple = $get_data_from_user($prompt, $input_type);
            $user_input = $tuple[0];
            $filtered_reply = $tuple[1];

            // does the user want to quit
            if (strtolower($user_input) === "q") {
                break 2;
            }

            $reply_checked = checkFilteredReply(
                $filtered_reply,
                $user_input,
                $input_type,
                $get_data_from_user,
                $prompt
            );

            $replies->push($reply_checked);
        }

        $contact_string = $replies->join(" ");
        $contacts->add($contact_string);
    };

    // @phan-suppress-next-line PhanPluginUnreachableCode
    $shouldNotQuit = !$contacts->isEmpty();

    if ($shouldNotQuit) {
        print PHP_EOL . purple("Here's what you entered:") . PHP_EOL;

        $contacts->reduce($display_result);

        $reply = readline(prompt("Does everything look good"));
    
        yes($reply)
            && generateContactsFile($contacts->toArray(), $path_to_contacts_file)
            && print PHP_EOL;
    
        $retry_message = red("Ok try again");
    
        no($reply) && setupContacts($path_to_contacts_file, $retry_message);
    }
}

function checkFilteredReply(
    string $filtered_reply,
    string $user_input,
    string $input_type,
    \Closure $ui_func,
    string $prompt
): string {
    if (!$filtered_reply) {
        $input_type_formatted = str_replace("_", " ", $input_type);
        $prompt = red("Oops! $user_input is not what is expected for $input_type_formatted") . PHP_EOL
            . $prompt;
        $tuple = $ui_func($prompt, $input_type);
        $user_input = $tuple[0];
        $filtered_reply = $tuple[1];

        return checkFilteredReply(
            $filtered_reply,
            $user_input,
            $input_type,
            $ui_func,
            $prompt
        );
    } else {
        return $filtered_reply;
    }
}

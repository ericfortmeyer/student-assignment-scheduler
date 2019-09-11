<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

use \Ds\{
    Vector,
    Set
};

use StudentAssignmentScheduler\ListOfContacts;
use StudentAssignmentScheduler\ListOfScheduleRecipients;

use function StudentAssignmentScheduler\Encryption\Functions\{
    box,
    unbox
};

if (!defined(__NAMESPACE__ . "\QUIT_MESSAGE")) {
    define(
        __NAMESPACE__ . "\QUIT_MESSAGE",
        "(type q after you have finished entering the contacts)"
    );
}

function addContacts(string $path_to_contacts_file, string $key, array $prompts = []): void
{
    print purple("Now adding to your list of contacts:") . PHP_EOL . PHP_EOL;

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
            && (function (Set $contacts, string $path_to_contacts_file, string $key) {

                box(
                    sensitiveData($contacts, $path_to_contacts_file, $key),
                    $path_to_contacts_file,
                    $key
                );

                print "Adding contacts successful!" . PHP_EOL;
            })($contacts, $path_to_contacts_file, $key);
    
        $retry_message = red("Ok try again");
    
        no($reply) && addContacts($path_to_contacts_file, $key, $prompts);
    }
}

function sensitiveData(Set $contacts, string $path_to_contacts_file, string $key): ListOfContacts
{
    return basename($path_to_contacts_file) === "schedule_recipients"
        ? (new ListOfScheduleRecipients($contacts->toArray()))->union(
            file_exists($path_to_contacts_file)
                    ? unbox($path_to_contacts_file, $key)
                    : new ListOfScheduleRecipients([])
        )
        : (new ListOfContacts($contacts->toArray()))->union(
            file_exists($path_to_contacts_file)
                ? new ListOfContacts(unbox($path_to_contacts_file, $key)->toArray())
                : new ListOfContacts([])
        );
}

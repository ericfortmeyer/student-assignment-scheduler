<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function \StudentAssignmentScheduler\Functions\generateContactsFile;

use \Ds\Vector;
use \Ds\Set;

if (!defined(__NAMESPACE__ . "\QUIT_MESSAGE")) {
    define(__NAMESPACE__ . "\QUIT_MESSAGE", "(type q for quit)");
}

function editContact(
    Set $OriginalContacts,
    int $key_of_original_contact,
    string $path_to_contacts_file,
    ?string $retry_message = null
): void {
    print  purple("Now changing {$OriginalContacts->get($key_of_original_contact)}") . PHP_EOL . PHP_EOL;

    $prompts = [
        "first_name" => "Enter first name",
        "last_name" => "Enter last name",
        "email_address" => "Enter email address"
    ];

    // use Set to prevent duplicates
    $contacts = new Set();

    $get_data_from_user = function (string $prompt, string $input_type): array {
        $tuple = exec("read -p '${prompt} ' input; echo \$input");
        print PHP_EOL;

        return $input_type === "email_address"
            ? [$tuple, filter_var($tuple, FILTER_VALIDATE_EMAIL)]
            : [$tuple, ucfirst($tuple)];
    };

    $display_old = function (string $contact): void {
        print red("-->") . " ${contact}" . PHP_EOL;
    };

    $display_new = function ($carry, string $contact): void {
        print green("-->") . " ${contact}" . PHP_EOL;
    };

    $replies = new Vector();

    foreach ($prompts as $input_type => $prompt) {
        // user's response
        $tuple = $get_data_from_user($prompt, $input_type);
        $user_input = $tuple[0];
        $filtered_reply = $tuple[1];


        $reply_checked = checkFilteredReply(
            $filtered_reply,
            $user_input,
            $input_type,
            $get_data_from_user,
            $prompt
        );

        $replies->push($reply_checked);
    };
    
    $contacts->add($replies->join(" "));


    print PHP_EOL . purple("Here's the old contact:") . PHP_EOL;
    $display_old($OriginalContacts->get($key_of_original_contact));

    print PHP_EOL . purple("Here's the what you entered:") . PHP_EOL;
    $contacts->reduce($display_new);


    $reply = readline(prompt("Does everything look good"));


    yes($reply)
        && (function (
            Set $contacts,
            Set $OriginalContacts,
            int $key_of_original_contact,
            string $path_to_contacts_file
        ) {
                $OriginalContacts->remove(
                    $OriginalContacts->get($key_of_original_contact)
                );
                
                
                generateContactsFile($contacts->union($OriginalContacts)->toArray(), $path_to_contacts_file);
                
                print "Editing contact successful!" . PHP_EOL;
        })($contacts, $OriginalContacts, $key_of_original_contact, $path_to_contacts_file);

    $retry_message = red("Ok try again");

    no($reply) && (function (Set $OriginalContacts, int $key_of_original_contact, string $path_to_contacts_file) {
        editContact($OriginalContacts, $key_of_original_contact, $path_to_contacts_file);
    });
}

<?php

namespace StudentAssignmentScheduler\CLI;


use StudentAssignmentScheduler\Classes\{
    ListOfContacts,
    Contact
};
use \Ds\Vector;
use function StudentAssignmentScheduler\Encryption\Functions\box;

if (!defined(__NAMESPACE__ . "\QUIT_MESSAGE")) {
    define(__NAMESPACE__ . "\QUIT_MESSAGE", "(type q for quit)");
}

function editContact(
    ListOfContacts $OriginalContacts,
    int $key_of_original_contact,
    string $path_to_contacts_file,
    string $secret_key,
    array $prompts
): void {
    print  purple("Now changing {$OriginalContacts->get($key_of_original_contact)}") . PHP_EOL . PHP_EOL;

    $get_data_from_user = function (string $prompt, string $input_type): array {
        $tuple = exec("read -p '${prompt} ' input; echo \$input");
        print PHP_EOL;

        return $input_type === "email_address"
            ? [$tuple, filter_var($tuple, FILTER_VALIDATE_EMAIL)]
            : [$tuple, ucfirst($tuple)];
    };

    $display_old = function (Contact $contact): void {
        print red("-->") . " ${contact}" . PHP_EOL;
    };

    $display_new = function ($carry, Contact $contact): void {
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

    
    $ModifiedContacts = new ListOfContacts(
        [new Contact($replies->join(" "))]
    );

    print PHP_EOL . purple("Here's the old contact:") . PHP_EOL;
    $display_old($OriginalContacts->get($key_of_original_contact));

    print PHP_EOL . purple("Here's the what you entered:") . PHP_EOL;
    $ModifiedContacts->reduce($display_new);


    $reply = readline(prompt("Does everything look good"));


    yes($reply)
        && (function (
            ListOfContacts $ModifiedContacts,
            ListOfContacts $OriginalContacts,
            int $key_of_original_contact,
            string $secret_key,
            string $path_to_contacts_file
        ) {
                $OriginalContacts->remove(
                    $OriginalContacts->get($key_of_original_contact)
                );

                box(
                    $ModifiedContacts->union($OriginalContacts),
                    $path_to_contacts_file,
                    $secret_key
                );
                
                print "Editing contact successful!" . PHP_EOL;
        })($ModifiedContacts, $OriginalContacts, $key_of_original_contact, $secret_key, $path_to_contacts_file);

    $retry_message = red("Ok try again");

    no($reply) && (function (
        ListOfContacts $OriginalContacts,
        int $key_of_original_contact,
        string $secret_key,
        string $path_to_contacts_file,
        array $prompts
    ) {
        editContact(
            $OriginalContacts,
            $key_of_original_contact,
            $secret_key,
            $path_to_contacts_file,
            $prompts
        );
    })($OriginalContacts, $key_of_original_contact, $secret_key, $path_to_contacts_file, $prompts);
}

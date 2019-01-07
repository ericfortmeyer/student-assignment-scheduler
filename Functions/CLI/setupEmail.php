<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use \Ds\Map;

function setupEmail(string $env_dir, string $env_filename = ".env"): void
{
    $message = purple("It looks like you haven't setup your email credentials yet") . PHP_EOL
        . "You will need:" . PHP_EOL
        . "1) the email address you will be using to send emails," . PHP_EOL
        . "2) the smtp host of the email, and" . PHP_EOL
        . "3) the password to the email account" . PHP_EOL;
    print $message;

    $reply = readline(prompt("Are you ready to enter the information for your the email address you will be using"));

    $prompts = new Map([
        "from_email" => "Enter your 'from' email address: ",
        "from_email_password" => "Enter the password to the email account: ",
        "smtp_host" => "Enter the smtp host of the email account: "
    ]);

    no($reply) && exit(red("Ok. See you later. Bye.") . PHP_EOL);

    $get_user_input = function (string $field_name, string $prompt): string {
            
        // this is the cleanest way to place a newline after the prompt
        $passwordPrompt = function (string $command) use ($prompt): string {
            print $prompt;
            $result = exec($command);
            print PHP_EOL;
            return $result;
        };

        /**
         * This script is necessary since the application uses 'read -s'
         * If this application is used with 'sh' on the CLI instead of 'bash'
         * the -s flag is unavailable and will throw and error
         * The readline function in PHP exposes the password which is the reason for using 'read -s'
         */
        $passwd_prompt_script = __DIR__ . "/../../bin/passwd_prompt.sh";


        // we don't want the password to show up in the terminal
        return $field_name === "from_email_password"
            ? $passwordPrompt("bash " . escapeshellcmd($passwd_prompt_script))
            : readline($prompt);
    };

    $encode_for_writing = function (string $field_name, string $binary_data): string {
        return base64_encode($binary_data);
    };

    $prepare_contents = function ($carry, string $field_name, string $data): string {
        return $carry . "${field_name}=${data}" . PHP_EOL;
    };

    // the replies from the user
    $replies = $prompts->map($get_user_input);

    // this needs to be encrypted
    $plaintext_password = $replies->remove("from_email_password");
    
    // encrypt the password
    $key = sodium_crypto_secretbox_keygen();
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $encrypted_password = sodium_crypto_secretbox(
        $plaintext_password,
        $nonce,
        $key
    );

    // saving binary data to the filesytem is unreliable
    $binary_data = new Map([
        "from_email_password" => $encrypted_password,
        "from_email_key" => $key,
        "from_email_nonce" => $nonce
    ]);

    // base 64 encode the binary data so that the data can be reliably saved
    $encoded = $binary_data->map($encode_for_writing);
    
    // combine the maps
    $combined = $encoded->union($replies);

    // serialize the data
    $file_contents = $combined->reduce($prepare_contents);

    $env_file = $env_dir . DIRECTORY_SEPARATOR . $env_filename;


    $prompt = prompt("Are you sure you want to replace the data on your env file");

    file_exists($env_file)
        ?  yes(readline($prompt)) && file_put_contents($env_file, $file_contents)
        : file_put_contents($env_file, $file_contents);


    print PHP_EOL;
}

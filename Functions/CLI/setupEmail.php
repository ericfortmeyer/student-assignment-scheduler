<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use \Ds\Map;

function setupEmail(string $env_dir, string $env_filename = ".env"): void
{
    $prompts = new Map([
        "from_email" => "Enter your 'from' email address: ",
        "from_email_password" => "Enter the password to the email account ",
        "smtp_host" => "Enter the smtp host of the email account "
    ]);

    $get_user_input = function (string $field_name, string $prompt) {
        return readline($prompt);
    };

    $encode_for_writing = function (string $field_name, string $binary_data): string {
        return \base64_encode($binary_data);
    };

    $prepare_contents = function ($carry, string $field_name, string $data) {
        return $carry . "${field_name}=${data}" . PHP_EOL;
    };

    // the replies from the user
    $replies = $prompts->map($get_user_input);

    // encrypt the password
    $plaintext_password = $replies->remove("from_email_password");
    $key = sodium_crypto_secretbox_keygen();
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $encrypted_password = sodium_crypto_secretbox(
        $plaintext_password,
        $nonce,
        $key
    );

    // it's not a good idea to save this to the filesystem
    $binary_data = new Map([
        "from_email_password" => $encrypted_password,
        "from_email_key" => $key,
        "from_email_nonce" => $nonce
    ]);

    // base 64 encoded
    $encoded = $binary_data->map($encode_for_writing);
    
    // combine the maps
    $combined = $encoded->union($replies);

    // serialize the data
    $file_contents = $combined->reduce($prepare_contents);

    $env_file = $env_dir . DIRECTORY_SEPARATOR . $env_filename;

    $prompt = prompt("Are you sure you want to replace your the data on your env file?");
    file_exists($env_file) && $reply = readline($prompt);

    yes($reply) && file_put_contents($env_file, $file_contents);
}

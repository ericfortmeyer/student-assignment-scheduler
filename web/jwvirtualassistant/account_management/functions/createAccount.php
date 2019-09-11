<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace jwvirtualassistant\AccountManagement;

use \PDO;

/**
 * Creates an account.
 */
function createAccount(
    PDO $db,
    UniqueUsername $username,
    Password $password,
    EmailOption $email_option
): array {
    return [
        $db->prepare(
            sprintf(
                "INSERT INTO %s (username, password, email, created_on, account_secret)"
                    . " VALUES (:username, :password, :email_option, :created_on, :account_secret)",
                USERS_TABLE
            ),
        )
        ->execute(
            [
                ":username" => (string) $username,
                ":password" => (string) $password,
                ":email_option" => (string) $email_option,
                ":created_on" => \date_create()->format("Y-m-d H:i:s"),
                ":account_secret" => $new_account_secret = \bin2hex(\random_bytes(32))
            ]
        ),
        $new_account_secret
    ];
}

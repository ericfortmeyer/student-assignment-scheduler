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
 * Updates an account's password.
 */
function updateAccountPassword(
    PDO $db,
    Username $username,
    Password $new_password
): array {
    return [
        $db->prepare(
            sprintf(
                "UPDATE %s SET
                password = :new_password,
                modified_on = :modified_on,
                account_secret = :account_secret
                WHERE username = :username",
                USERS_TABLE
            )
        )
        ->execute(
            [
                ":username" => (string) $username,
                ":new_password" => (string) $new_password,
                ":modified_on" => \date_create()->format("Y-m-d H:i:s"),
                ":account_secret" => $new_account_secret = \bin2hex(\random_bytes(32))
            ]
        ),
        $new_account_secret
    ];
}

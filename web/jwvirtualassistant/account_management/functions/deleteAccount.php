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
 * Use the username to delete the account
 *
 * @param PDO $db
 * @param Username $username
 * @return bool Result of executing sql statement
 */
function deleteAccount(
    PDO $db,
    Username $username
): bool {
    return $db->prepare(
        sprintf(
            "DELETE FROM %s WHERE username = :username",
            USERS_TABLE
        ),
    )
        ->execute(
            [":username" => (string) $username]
        );
}

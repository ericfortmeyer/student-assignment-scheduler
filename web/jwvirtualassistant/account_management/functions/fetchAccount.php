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
 * Returns a representation of a user's account information.
 *
 * @param PDO $db
 * @param Username $username
 * @return Account
 */
function fetchAccount(
    PDO $db,
    Username $username
): Account {
    $stmt = $db->prepare(
        sprintf(
            "SELECT * FROM %s WHERE username = :username",
            USERS_TABLE
        )
    );
    $stmt->execute([":username" => (string) $username]);
    $result = $stmt->fetchObject();
    $accountNotFound = (bool) $result === false;

    if ($accountNotFound) {
        throw new AccountNotFoundException(
            sprintf(
                "There is no account with username %s",
                (string) $username
            )
        );
    }
    return new Account($result);
}

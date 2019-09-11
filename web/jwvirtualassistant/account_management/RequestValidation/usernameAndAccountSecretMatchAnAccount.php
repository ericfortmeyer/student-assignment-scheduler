<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */


namespace jwvirtualassistant\AccountManagement\RequestValidation;

use \PDO;
use const jwvirtualassistant\AccountManagement\USERS_TABLE;
use jwvirtualassistant\AccountManagement\Username;

/**
 * Returns a representation of a user's account information.
 *
 * @param PDO $db
 * @param Username $username
 * @param string $account_secret
 * @return bool
 */
function usernameAndAccountSecretMatchAnAccount(
    PDO $db,
    Username $username,
    string $account_secret
): bool {
    $stmt = $db->prepare(
        sprintf(
            "SELECT * FROM %s WHERE account_secret = :account_secret AND username = :username",
            USERS_TABLE
        )
    );
    $stmt->execute(
        [
            ":account_secret" => (string) $account_secret,
            ":username" => (string) $username
        ]
    );
    $result = $stmt->fetchObject();
    $matchingAccountFound = (bool) $result !== false;
    return $matchingAccountFound;
}

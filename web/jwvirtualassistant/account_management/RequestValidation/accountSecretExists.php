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

/**
 * Returns a representation of a user's account information.
 *
 * @param PDO $db
 * @param string $account_secret
 * @return bool
 */
function accountSecretExists(
    PDO $db,
    string $account_secret
): bool {
    $stmt = $db->prepare(
        sprintf(
            "SELECT * FROM %s WHERE account_secret = :account_secret",
            USERS_TABLE
        )
    );
    $stmt->execute([":account_secret" => (string) $account_secret]);
    $result = $stmt->fetchObject();
    $accountSecretExists = (bool) $result !== false;
    return $accountSecretExists;
}

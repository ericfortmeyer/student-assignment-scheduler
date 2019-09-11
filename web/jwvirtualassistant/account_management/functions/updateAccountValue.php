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

function updateAccountValue(
    PDO $db,
    Username $username,
    ValueType $new_value
): bool {
    return $db->prepare(
        sprintf(
            "UPDATE %s SET %s = :new_value, modified_on = :modified_on WHERE username = :username",
            USERS_TABLE,
            $new_value->getType()
        )
    )
    ->execute(
        [
            ":username" => (string) $username,
            ":new_value" => (string) $new_value,
            ":modified_on" => \date_create()->format("c")
        ]
    );
}

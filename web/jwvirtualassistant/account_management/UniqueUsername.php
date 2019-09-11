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
 * A representation of a username that is not used by any other account.
 */
final class UniqueUsername extends ValueType
{
    /**
     * A database connection will be used to verify that the username
     * is unique.
     *
     * @var PDO $db
     */
    private $db;

    /**
     * Create the instance.
     * 
     * @param PDO $db
     * @param string $value
     */
    public function __construct(PDO $db, string $value)
    {
        $this->db = $db;
        parent::__construct($value);
    }

    /**
     * Retrieve the validator.
     */
    protected function getValidator(): \Closure
    {
        /**
         * Return true if the value is invalid.
         */
        return function (string $value): array {
            $maxlen = 100;
            $tooLong = strlen($value) > $maxlen;
            $isNotUnique = $this->isNotUnique(new Username($value), $this->db);
            return $isNotUnique
                ? [
                    $isInvalid = true,
                    sprintf("%s is not a unique username.  Please try another username.", $value)
                ]
                : (
                    $tooLong
                        ? [
                            $isInvalid = true,
                            sprintf("%s should be no more than %s characters in length", $value, $maxlen)
                        ]
                        : [false, ""]
                );
        };
    }

    /**
     * Is the username unique?
     *
     * @param Username $username
     * @param PDO $db
     * @return bool
     */
    protected function isNotUnique(Username $username, PDO $db): bool
    {
        try {
            fetchAccount($db, $username);
            return true;
        } catch (AccountNotFoundException $e) {
            return false;
        }
    }
}
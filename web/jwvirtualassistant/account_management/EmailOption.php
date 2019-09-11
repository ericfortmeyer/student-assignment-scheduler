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

/**
 * A representation of an email address.
 */
final class EmailOption extends ValueType
{
    protected const PATTERN = "/^[[:alpha:]]{1,255}$/";

    private const TYPE = "email";

    /**
     * {@inheritDoc}
     * @todo check database for previously existing usernames
     */
    protected function getValidator(): \Closure
    {
        /**
         * Return true if the value is invalid.
         */
        return function (string $value): array {
            $maxlen = 50;
            $notEmpty = !empty($value);
            $tooLong = (bool) strlen($value) > $maxlen;
            $notValidEmail = (bool) !filter_var($value, FILTER_VALIDATE_EMAIL);
            return [
                $isInvalid = $notEmpty
                    ? ($tooLong || $notValidEmail)
                    : false, // empty string allowed
                sprintf(
                    "Email address is invalid or is more than %s characters in length",
                    $maxlen
                )
            ];
        };
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}

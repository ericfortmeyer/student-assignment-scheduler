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
 * A representation of a username.
 */
final class Username extends ValueType
{
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
            $maxlen = 255;
            return [
                strlen($value) > $maxlen,
                sprintf("%s should be no more than %s characters in length", __CLASS__, $maxlen)
            ];
        };
    }
}
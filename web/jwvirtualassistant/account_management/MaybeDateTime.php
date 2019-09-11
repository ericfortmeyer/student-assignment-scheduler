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

use \DateTimeImmutable;
use \DateTimeZone;
use \Exception;

/**
 * Represents a DateTimeImmutable instance or an empty string
 */
final class MaybeDateTime
{
    /**
     * @var DateTimeImmutable|string $value
     */
    protected $value = "";

    /**
     * Create the instance.
     *
     * @param string $time_or_empty_string
     * @param DateTimeZone|null $timezone
     */
    public function __construct(string $time_or_empty_string, ?DateTimeZone $timezone = null)
    {
        if (!empty($time_or_empty_string)) {
            try {
                $this->value = new DateTimeImmutable($time_or_empty_string, $timezone);
            } catch (Exception $e) {
            }
        }
    }

    public function format(string $format): string
    {
        return $this->value instanceof DateTimeImmutable
            ? $this->value->format($format)
            : $this->value;
    }
}
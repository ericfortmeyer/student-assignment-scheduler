<?php

namespace StudentAssignmentScheduler\Classes;

use \Ds\Set;

final class Guid
{
    private const GUID_PATTERN = "/^[[:xdigit:]]{8}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{4}-[[:xdigit:]]{12}$/";

    /**
     * @var string $value
     */
    private $value;

    private const THIRD_SET_ALLOWED = [4];
    private const FOURTH_SET_ALLOWED = [8, 9, "A", "B"];

    public function __construct(?string $guid = null)
    {
        $this->value = $guid ?? join("-", [
            $this->chars(8),
            $this->chars(4),
            $this->chars(4)->havingFirstCharacterOfSet(new Set(self::THIRD_SET_ALLOWED)),
            $this->chars(4)->havingFirstCharacterOfSet(new Set(self::FOURTH_SET_ALLOWED)),
            $this->chars(12)
        ]);

        $this->validate($this->value);
    }

    /**
     * Perform validation of Guid string.
     *
     * @throws \InvalidArgumentException
     * @param string $string_to_test Value to test
     * @return void
     */
    private function validate(string $string_to_test): void
    {
        $stringIsValid = (function (string $string_to_test): \Closure {
            return function () use ($string_to_test): bool {
                return preg_match(self::GUID_PATTERN, $string_to_test) !== 0;
            };
        })($string_to_test);

        $throwAnException = (function (string $failed_string): \Closure {
            return function () use ($failed_string): void {
                throw new \InvalidArgumentException("{$failed_string} is not a valid GUID");
            };
        })($string_to_test);

        $stringIsValid() or $throwAnException();
    }

    private function chars(int $length): object
    {
        return new class ($length) {
            
            private $length;

            private $chars = "";
            
            public function __construct(int $length)
            {
                $this->length = $length;

                $this->chars = $this->randomChars($length);
            }

            public function havingFirstCharacterOfSet(Set $allowed_first_characters): string
            {
                $copy = clone $this;
                
                // since shuffle function mutates the array
                $allowed_chars_as_array = $allowed_first_characters->toArray();
                \shuffle($allowed_chars_as_array);

                return $allowed_chars_as_array[0] . \substr($this->chars, 1);
            }
            
            private function randomChars(int $length): string
            {
                return \sodium_bin2hex(
                    \random_bytes(
                        $length / 2  // since hex is double the length of binary
                    )
                );
            }

            public function __toString()
            {
                return $this->chars;
            }
        };
    }


    public function __toString()
    {
        return $this->value;
    }
}

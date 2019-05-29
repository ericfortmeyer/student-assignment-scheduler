<?php

namespace StudentAssignmentScheduler;

use PHPUnit\Framework\TestCase;

class MaybeContactTest extends TestCase
{
    public function testMaybeContactGetOrElseFunctionCallsGivenFunctionWhenEmpty()
    {
        $MaybeContact = MaybeContact::init(new Contact("Thelonious Monk tm@aol.com"));
        $MaybeContact__empty = MaybeContact::init(null);
        $MaybeContact__false = MaybeContact::init(false);

        $this->assertInstanceOf(
            Contact::class,
            $MaybeContact->getOrElse(
                function (): bool {
                    return false;
                }
            )
        );

        $this->assertFalse(
            $MaybeContact__empty->getOrElse(
                function (): bool {
                    return false;
                }
            )
        );

        $this->assertFalse(
            $MaybeContact__false->getOrElse(
                function (): bool {
                    return false;
                }
            )
        );
    }
}

<?php

namespace StudentAssignmentScheduler\AccountManagement;

use PHPUnit\Framework\TestCase;

use \DateTimeImmutable;

class AccountArrayTest extends TestCase
{
    public function testAccountArrayThatIsCastToAnArrayIsAsExpected()
    {
        $given_ids = [1, 2, 3];
        $accounts = array_map(
            function (int $id): Account {
                return new Account($id);
            },
            $given_ids
        );

        $account_array = new AccountArray($accounts);

        $this->assertSame(
            $account_array[0],
            $accounts[0]
        );

        $this->assertSame(
            (array) $account_array,
            $accounts
        );
    }
}

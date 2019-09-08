<?php

namespace StudentAssignmentScheduler\AccountManagement;

use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testGet_Array_CopyMethodProducesExpectedResult()
    {
        $given_id = 1;
        $given_account_instance = new Account($given_id);

        [$id, $expected_account_instance] = $given_account_instance->getArrayCopy();

        $this->assertInstanceOf(
            Account::class,
            $expected_account_instance
        );

        $this->assertSame(
            $given_account_instance,
            $expected_account_instance
        );

        $this->assertSame(
            $id,
            $given_id
        );
    }

    public function testFromMethodProducesA_NewAccountWithTheSameValues()
    {
        $given_id = 1;

        $given_account = new Account($given_id);
        $account_info_from_given_account = $given_account->jsonSerialize();
        $copy_of_account = Account::from($account_info_from_given_account);
        $this->assertFalse(
            $given_account === $copy_of_account
        );

        $this->assertSame(
            \json_encode($given_account),
            \json_encode($copy_of_account)
        );
    }
}

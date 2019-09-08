<?php

namespace StudentAssignmentScheduler\AccountManagement;

use PHPUnit\Framework\TestCase;

class AccountsStoreFactoryTest extends TestCase
{
    public function testCreatesJsonAccountStoreInstance()
    {
        $factory = new AccountsStoreFactory();
        $store = $factory(AccountStore::class);
        $this->assertInstanceOf(
            AccountStore::class,
            $store
        );

    }

    public function testThrowsOutOfBoundsWhenGivenAnInvalidStoreType()
    {
        $factory = new AccountsStoreFactory();
        try {
            $factory(TestCase::class);
            $this->assertFalse(true); // test failed
        } catch (\OutOfBoundsException $e) {
            $this->assertTrue(true); // test passed
        }
    }
}

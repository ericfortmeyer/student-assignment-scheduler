<?php

namespace StudentAssignmentScheduler\AccountManagement;

use StudentAssignmentScheduler\Mocks\MockAccountStoreService;

use PHPUnit\Framework\TestCase;

class AccountStoreTest extends TestCase
{
    protected function setUp(): void
    {
        require_once __DIR__ . "/../../mocks/MockAccountStoreService.php";
    }

    public function testAccountStoreCreatesAccount()
    {
        $accountStoresToTest = [
            new AccountStore(new MockAccountStoreService)
        ];

        $doTest = function (array $accountStoresToTest): void {
            $ids = [1, 2, 3];

            $accounts = array_map(
                function (int $id): Account {
                    return new Account($id);
                },
                $ids
            );
    
            [$account1, $account2, $account3] = $accounts;
    
            $this->assertFalse(
                $account1 == $account2
            );
    
            $this->assertFalse(
                $account2 == $account3
            );
    
            array_map(
                function (AccountStore $account_store) use ($accounts, $ids): void {
                    array_map(
                        function (Account $account) use ($account_store) {
                            $this->assertTrue(
                                $account_store->create($account)
                            );
                        },
                        $accounts
                    );
                    array_map(
                        function (Account $account, int $id) use ($account_store) {
                            $this->assertInstanceOf(
                                Account::class,
                                $account_store->get($id)->getOrElse(function () {return false;})
                            );
                    
                            $this->assertSame(
                                $account,
                                $account_store->get($id)->getOrElse(function () {return false;})
                            );
                            
                            $this->assertFalse(
                                $account_store->get(0)->getOrElse(function () {return false;})
                            );
                        },
                        $accounts,
                        $ids
                    );
                },
                $accountStoresToTest
            );
        };

        $doTest($accountStoresToTest);
    }

    public function testAccountStore_get_array_copy_MethodProducesExpectedResult()
    {
        $accountStoresToTest = [
            new AccountStore(new MockAccountStoreService),
        ];

        $ids = [1, 2, 3];
        $accounts = array_map(
            function (int $id): Account {
                return new Account($id);
            },
            $ids
        );

        array_map(
            function (AccountStore $account_store_to_test) use ($ids, $accounts): void {
                array_map(
                    function (Account $account) use ($account_store_to_test): void {
                        $account_store_to_test->create($account);
                    },
                    $accounts
                );
                $this->assertSame(
                    $account_store_to_test->getArrayCopy(),
                    [
                        $ids[0] => $accounts[0],
                        $ids[1] => $accounts[1],
                        $ids[2] => $accounts[2]
                    ]
                );
            },
            $accountStoresToTest
        );

    }

    public function testAccountStoreCanRevokeAnAccount()
    {
        $id = 1;
        $account = new Account($id);
        $FakeAccountStore = new AccountStore(new MockAccountStoreService);
        $FakeAccountStore->create($account);
        $FakeAccountStore->revoke($id);
        $this->assertFalse(
            $FakeAccountStore->get($id)->getOrElse(function () {return false;})
        );

        $this->assertTrue(
            $FakeAccountStore->isRevoked($id)
        );
    }

    public function testAccountStoreCanRestoreAnAccount()
    {
        $id = 1;
        $account = new Account($id);
        $FakeAccountStore = new AccountStore(new MockAccountStoreService);
        $FakeAccountStore->create($account);
        $FakeAccountStore->revoke($id);
        $this->assertFalse(
            $FakeAccountStore->get($id)->getOrElse(function () {return false;})
        );
        $this->assertTrue(
            $FakeAccountStore->isRevoked($id)
        );
        $FakeAccountStore->restore($id);
        $this->assertInstanceOf(
            Account::class,
            $FakeAccountStore->get($id)->getOrElse(function () {return false;})
        );
        $this->assertFalse(
            $FakeAccountStore->isRevoked($id)
        );
    }
}

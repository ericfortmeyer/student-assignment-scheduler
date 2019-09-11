<?php

namespace StudentAssignmentScheduler\AccountManagement;

use PHPUnit\Framework\TestCase;
use StudentAssignmentScheduler\AccountManagement\{
    Services\JsonDocumentStoreService,
    Services\SqliteStoreService
};
use StudentAssignmentScheduler\Exception\InvalidTableNameException;

class AccountManagementTest extends TestCase
{
    protected function setUp(): void
    {
        $path_to_fake_json_account_stores = __DIR__ . "/../../tmp";
        $this->fake_json_account_ref = "${path_to_fake_json_account_stores}/fake_json_accounts.json";
        $this->fake_json_revoked_account_ref = "${path_to_fake_json_account_stores}/fake_json_revoked_accounts.json";
        $this->fake_sqlite_db = __DIR__ . "/../fake_data/fake.sq3";
        $this->AccountStoreWithJsonService = new AccountStore(new JsonDocumentStoreService(
            new AccountStoreReference($this->fake_json_account_ref),
            new AccountStoreReference($this->fake_json_revoked_account_ref),
        ));
        $this->AccountStoreWithSqliteService = new AccountStore(new SqliteStoreService(
            new AccountStoreReference($this->fake_sqlite_db)
        ));
    }

    public function testAccountStoreCreatesAccount()
    {
        $accountStoresToTest = [
            $this->AccountStoreWithJsonService,
            $this->AccountStoreWithSqliteService
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
            $this->AccountStoreWithJsonService,
            $this->AccountStoreWithSqliteService
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

    public function testAccountStoreFetchesExistingDataFromJsonDocumentStore()
    {
        $FakeAccountStore = new AccountStore(new JsonDocumentStoreService(
            new AccountStoreReference(__DIR__ . "/../fake_data/accounts.json"),
            new AccountStoreReference(__DIR__ . "/non_existent_file.json")
        ));
        $this->assertFalse(
            $FakeAccountStore->getArrayCopy() === []
        );
    }

    public function testAccountStoreFetchesDataFromExistingSqliteDatabase()
    {
        $fake_db = __DIR__ . "/../fake_data/fake2.sq3";
        $given_account_id = 1;
        $createAccountStore = function (string $path_to_database): AccountStore {
            return new AccountStore(new SqliteStoreService(new AccountStoreReference($path_to_database)));
        };
        $OriginalFakeAccountStore = $createAccountStore($fake_db);
        $account = new Account($given_account_id);
        $OriginalFakeAccountStore->create($account);
        unset($OriginalFakeAccountStore);
        $NewFakeAccountStore = $createAccountStore($fake_db);
        $this->assertEquals(
            $account,
            $NewFakeAccountStore->get($given_account_id)->getOrElse(function () {return new Account();})
        );
        file_exists($fake_db) && unlink($fake_db);
    }

    public function testSqliteStoreThrowExceptionIfTableNameIsNotValid()
    {
        try {
            $service = new SqliteStoreService(new AccountStoreReference(":memory:"));
            $service->fetchAll(new AccountType("illegal account type name"));
            $this->assertFalse(true); // test failed
        } catch (InvalidTableNameException $e) {
            $this->assertTrue(true); // test passed
        }
    }

    protected function tearDown(): void
    {
        array_map(
            function (string $path_to_delete) {
                file_exists($path_to_delete) && unlink($path_to_delete);
            },
            [
                $this->fake_json_account_ref,
                $this->fake_json_revoked_account_ref,
                $this->fake_sqlite_db,
                __DIR__ . "/non_existent_file.json"
            ]
        );
    }
}

<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Mocks;

use StudentAssignmentScheduler\AccountManagement\Services\AccountStoreServiceInterface;

use StudentAssignmentScheduler\AccountManagement\{
    AccountStoreReference,
    AccountArray,
    AccountType
};

final class MockAccountStoreService implements AccountStoreServiceInterface
{
    public function store(AccountType $account_type, AccountArray $accounts): void
    {
        // no op
    }

    public function fetchAll(AccountType $account_type): AccountArray
    {
        return new AccountArray([]);
    }
}


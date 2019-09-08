<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement\Services;

use StudentAssignmentScheduler\AccountManagement\{
    AccountType,
    AccountArray
};

/**
 * Provides an api for the account store to communicate
 * with it's services.
 *
 * Having one account store with many possible services helps
 * to make future modifications more flexible.  It also adds
 * testability to the account management module.
 */
interface AccountStoreServiceInterface
{
    /**
     * Stores information in the store.
     *
     * @param AccountType $account_type
     * @param AccountArray $accounts
     * @return void
     */
    public function store(AccountType $account_type, AccountArray $accounts): void;

    /**
     * Fetch all information from the store.
     *
     * @param AccountType $account_type
     * @return AccountArray
     */
    public function fetchAll(AccountType $account_type): AccountArray;
}

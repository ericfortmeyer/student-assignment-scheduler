<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement;

use \Ds\Map;

final class AccountStore extends \ArrayObject implements AccountStoreInterface
{
    /**
     * @var Services\AccountStoreServiceInterface $service
     */
    private $service;

    /**
     * @var Map $accounts
     */
    private $accounts;

    /**
     * @var Map $revokedAccounts
     */
    private $revokedAccounts;

    public function __construct(Services\AccountStoreServiceInterface $service)
    {
        $this->service = $service;
        $this->accounts = new Map($service->fetchAll(new AccountType(AccountTypes::ACCOUNTS)));
        $this->revokedAccounts = new Map($service->fetchAll(new AccountType(AccountTypes::REVOKED_ACCOUNTS)));
    }

    public function __destruct()
    {
        $this->service->store(
            new AccountType(AccountTypes::ACCOUNTS),
            new AccountArray($this->accounts->toArray())
        );
        $this->service->store(
            new AccountType(AccountTypes::REVOKED_ACCOUNTS),
            new AccountArray($this->revokedAccounts->toArray())
        );
    }

    public function create(Account $account): bool
    {
        $this->accounts->put(...$account->getArrayCopy());
        return true;
    }

    public function get(int $id): MaybeAccount
    {
        return new MaybeAccount($this->accounts->get($id, false));
    }

    public function revoke(int $id): bool
    {
        $revoked_account = $this->accounts->remove($id);
        $this->revokedAccounts->put($id, $revoked_account);
        return true;
    }
    
    public function restore(int $id): bool
    {
        $account_to_restore = $this->revokedAccounts->remove($id);
        $this->accounts->put($id, $account_to_restore);
        return true;
    }

    public function getArrayCopy(): array
    {
        return $this->accounts->toArray();
    }

    public function isRevoked(int $id): bool
    {
        return $this->revokedAccounts->hasKey($id);
    }
}

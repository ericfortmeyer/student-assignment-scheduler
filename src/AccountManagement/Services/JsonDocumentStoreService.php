<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement\Services;

use StudentAssignmentScheduler\AccountManagement\{
    AccountStoreReference,
    AccountType,
    AccountTypes,
    AccountArray,
    Account
};

use \Ds\Map;

final class JsonDocumentStoreService implements AccountStoreServiceInterface
{
    /**
     * @var AccountStoreReference $accounts_reference
     */
    private $accounts_reference;

    /**
     * @var AccountStoreReference $revoked_accounts_reference
     */
    private $revoked_accounts_reference;

    /**
     * @var Map $data_references
     */
    private $data_references;

    public function __construct(AccountStoreReference $path_to_data, AccountStoreReference $path_to_revoked_accounts)
    {
        $this->accounts_reference = $path_to_data;
        $this->revoked_accounts_reference = $path_to_revoked_accounts;
        $this->data_references = new Map([
            AccountTypes::ACCOUNTS => $this->accounts_reference,
            AccountTypes::REVOKED_ACCOUNTS => $this->revoked_accounts_reference
        ]);
        /**
         * @codeCoverageIgnore
         */
        $createDir = function (string $account_type, AccountStoreReference $account_ref): void {
            !\file_exists(dirname((string) $account_ref))
                && \mkdir(dirname((string) $account_ref));
        };
        $this->data_references->map($createDir);
    }

    public function store(AccountType $account_type, AccountArray $accounts): void
    {
        $data_reference = $this->data_references->get((string) $account_type);
        $this->write($data_reference, $accounts);
    }

    public function fetchAll(AccountType $account_type): AccountArray
    {
        $data_reference = $this->data_references->get((string) $account_type);
        return $this->read($data_reference);
    }

    private function read(AccountStoreReference $data_reference): AccountArray
    {
        $getData = function (AccountStoreReference $data_reference): array {
            $path_to_data = (string) $data_reference;
            return \file_exists($path_to_data)
                ? \json_decode(\file_get_contents($path_to_data), true)
                : [];
        };
        $createAccountInstances = function (array $account_info): Account {
            return Account::from($account_info);
        };
        return new AccountArray(
            array_map(
                $createAccountInstances,
                $getData($data_reference)
            )
        );
    }

    private function write(AccountStoreReference $data_reference, AccountArray $data): bool
    {
        $path_to_data = (string) $data_reference;
        return (bool) file_put_contents($path_to_data, json_encode((array) $data, JSON_PRETTY_PRINT));
    }
}

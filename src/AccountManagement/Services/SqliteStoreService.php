<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement\Services;

use StudentAssignmentScheduler\AccountManagement\{
    AccountType,
    AccountArray,
    Account,
    AccountStoreReference
};

use StudentAssignmentScheduler\Exception\InvalidTableNameException;

use \PDO;

final class SqliteStoreService implements AccountStoreServiceInterface
{
    private const TABLE_NAMES = ["accounts", "revoked_accounts"];

    /**
     * @var \PDO $db
     */
    private $db;

    /**
     * Create the instance.
     *
     * @param AccountStoreReference $path_to_database
     */
    public function __construct(AccountStoreReference $path_to_database)
    {
        $this->db = new \PDO("sqlite:${path_to_database}");
        $create_table_if_not_exists = function (string $table_name): void {
            $this->throwExceptionIfTableNameIsInvalid($table_name);
            $this->db
                ->prepare(
                    "CREATE TABLE IF NOT EXISTS ${table_name} (id INT(200) NOT NULL PRIMARY KEY, created_on DATETIME)"
                )
                ->execute();
        };
        array_map($create_table_if_not_exists, self::TABLE_NAMES);
    }

    public function store(AccountType $account_type, AccountArray $accounts): void
    {
        $this->throwExceptionIfTableNameIsInvalid((string) $account_type);
        if ($accounts->count() === 0) {
            return;
        }
        $stmt = $this->db->prepare(
            $sql = "INSERT OR IGNORE INTO ${account_type} VALUES ({$this->composeInsertClause($accounts)})"
        );
        $stmt->execute($this->composeInputParameters($accounts));
    }

    public function fetchAll(AccountType $account_type): AccountArray
    {
        $this->throwExceptionIfTableNameIsInvalid((string) $account_type);
        $stmt = $this->db->prepare("SELECT id, created_on FROM ${account_type}");
        $stmt->execute();
        // @phan-suppress-next-line PhanUndeclaredFunctionInCallable
        return new AccountArray($stmt->fetchAll(PDO::FETCH_CLASS, Account::class));
    }

    /**
     * @throws InvalidTableNameException
     */
    private function throwExceptionIfTableNameIsInvalid(string $table_name): void
    {
        if (!in_array($table_name, self::TABLE_NAMES)) {
            throw new InvalidTableNameException($table_name, self::TABLE_NAMES);
        }
    }

    private function composeInsertClause(AccountArray $accounts): string
    {
        return join("), (", (array) $accounts);
    }

    private function composeInputParameters(AccountArray $accounts): array
    {
        $inputParams = array_map(
            function (Account $account): array {
                return $account->sqlInputParameters();
            },
            (array) $accounts
        );
        return array_merge(...$inputParams);
    }
}

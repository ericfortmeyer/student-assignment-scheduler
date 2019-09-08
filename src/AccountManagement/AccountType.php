<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement;

final class AccountType
{
    /**
     * @var string $account_type
     */
    private $account_type = "";
    
    public function __construct(string $account_type)
    {
        $this->account_type = $account_type;
    }

    public function __toString()
    {
        return $this->account_type;
    }
}

<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement;

/**
 * Represents a string that can be used to access the account store.
 */
final class AccountStoreReference
{
    /**
     * A string used to access the account store.
     *
     * @var string $data_reference
     */
    private $data_reference = "";

    /**
     * Create the instance.
     */
    public function __construct(string $data_reference)
    {
        $this->data_reference = $data_reference;
    }

    public function __toString()
    {
        return $this->data_reference;
    }
}

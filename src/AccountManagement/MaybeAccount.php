<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement;

final class MaybeAccount
{
    /**
     * @var Account|false
     */
    private $searchResult;

    public function __construct($result)
    {
        $this->searchResult = $result;
    }

    /**
     * Will return the account that was found or
     * execute the specified action.
     *
     * @param \Closure $actionIfNotFound
     * @return Account|mixed
     */
    public function getOrElse(\Closure $actionIfNotFound)
    {
        return $this->searchResult ? $this->searchResult : $actionIfNotFound();
    }
}

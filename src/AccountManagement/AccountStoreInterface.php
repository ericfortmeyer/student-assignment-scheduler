<?php declare(strict_types=1);
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\AccountManagement;

interface AccountStoreInterface
{
    /**
     * Creates an account.
     *
     * @param Account $account
     * @return bool
     */
    public function create(Account $account): bool;

    /**
     * Uses an id to attempt to retrieve a representation of an account.
     *
     * @param int $id
     * @return MaybeAccount
     */
    public function get(int $id): MaybeAccount;

    /**
     * Removes an account's authorization to it's resources.
     *
     * @param int $id
     * @return bool
     */
    public function revoke(int $id): bool;

    /**
     * Restores an accounts authorization to it's resources.
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool;

    /**
     * Returns whether or not an account has been revoked.
     *
     * @param int $id
     * @return bool
     */
    public function isRevoked(int $id): bool;
}

<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore;

use StudentAssignmentScheduler\Password;

final class PasswordOption
{
    /**
     * @var Password|null $passwd
     */
    private $passwd;

    public function __construct(?Password $passwd = null)
    {
        $this->passwd = $passwd;
    }

    public function select(\Closure $withPasswordAction, \Closure $withoutPasswordAction): void
    {
        $this->passwd !== null
            ? $withPasswordAction($this->passwd)
            : $withoutPasswordAction($this->passwd);
    }
}

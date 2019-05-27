<?php declare(strict_types=1);

namespace StudentAssignmentScheduler;

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

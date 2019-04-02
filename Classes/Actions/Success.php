<?php

namespace StudentAssignmentScheduler\Classes\Actions;

use \Closure;

final class Success
{
    /**
     * @var Closure $action
     */
    private $action;

    public function __construct(Closure $action)
    {
        $this->action = $action;
    }

    public function __invoke($arg = null)
    {
        $closure = $this->action;
        return $closure($arg);
    }
}

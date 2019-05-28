<?php

namespace StudentAssignmentScheduler\Actions;

use \Closure;

final class Failure
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

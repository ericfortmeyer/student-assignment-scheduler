<?php

namespace StudentAssignmentScheduler\Rules;

use \Closure;

abstract class AbstractRule implements RuleInterface
{
    /**
     * @var Context $context
     */
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    abstract public function result(): Result;
}

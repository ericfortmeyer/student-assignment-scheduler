<?php

namespace StudentAssignmentScheduler\Rules;

use \Closure;
/**
 * Used to make logic an input to functions.
 *
 * Requires a context which is a map containing
 * key value pairs of things that will be tested.
 *
 */
interface RuleInterface
{
    /**
     * @return Closure
     */
    public function result(): Result;
}

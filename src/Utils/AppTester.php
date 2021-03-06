<?php

namespace StudentAssignmentScheduler\Utils;

final class AppTester
{
    /**
     * @var object $test_class
     */
    private $test_class;

    public function given(string $given_class_name, ...$constructor_args): self
    {
        $this->test_class = new $given_class_name(...$constructor_args);
        return $this;
    }

    public function useInstance(object $instance): self
    {
        $this->test_class = $instance;
        return $this;
    }

    public function with(callable $withMethod, ...$args): self
    {
        $this->test_class = call_user_func($withMethod, ...$args);
        return $this;
    }

    public function when($operation, ...$args): self
    {
        call_user_func(
            $operation,
            ...array_map(
                function ($arg) {
                    return is_string($arg) && $this->test_class instanceof $arg
                        ? $this->test_class
                        : $arg;
                },
                $args
            )
        );

        return $this;
    }

    public function then(\Closure $func, ...$args): void
    {
        $func(...$args);
    }
}

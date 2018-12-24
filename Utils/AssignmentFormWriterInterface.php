<?php

namespace StudentAssignmentScheduler\Utils;

interface AssignmentFormWriterInterface
{
    public function create(array $data): void;
}

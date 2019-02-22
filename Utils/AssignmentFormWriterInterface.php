<?php

namespace StudentAssignmentScheduler\Utils;

interface AssignmentFormWriterInterface
{
    public function create(string $assignment_number, array $data): void;
}

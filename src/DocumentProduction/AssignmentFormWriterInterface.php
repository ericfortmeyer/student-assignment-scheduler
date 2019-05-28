<?php

namespace StudentAssignmentScheduler\DocumentProduction;

interface AssignmentFormWriterInterface
{
    public function create(string $assignment_number, array $data, string $basename_of_target_file_with_ext): void;
}

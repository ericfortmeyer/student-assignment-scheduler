<?php

namespace StudentAssignmentScheduler\Functions;

function hashOfFile(string $filename): string
{
    return sha1_file($filename);
}

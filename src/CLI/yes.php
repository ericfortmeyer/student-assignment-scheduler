<?php

namespace StudentAssignmentScheduler\CLI;

function yes(string $reply): bool
{
    list($yes, $no) = [["y", "Y", "yes", "Yes", "YES"],["n", "N", "no", "No", "NO"]];
    return in_array($reply, $yes);
}

<?php

namespace StudentAssignmentScheduler\Functions;

/**
 * Remove "_*" and file extension from filename
 * allows: Eric.pdf, Eric_2.pdf, Eric_3.pdf
 */
function firstNameFromFilename(string $filename): string
{
    return current(
        explode(
            "_",
            basename($filename, ".pdf")
        )
    );
}

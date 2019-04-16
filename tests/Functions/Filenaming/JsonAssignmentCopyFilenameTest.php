<?php

namespace StudentAssignmentScheduler\Functions\Filenaming;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Classes\Destination;

use \DateTimeImmutable;

use function StudentAssignmentScheduler\Functions\Bootstrapping\buildPath;

class JsonAssignmentCopyFilenameTest extends TestCase
{
    /* 
        The function receives as input:
        (1) destination
        (2) date_time
        (3) original filename

        The function should output:
        directory + date_time_string + original filename + file extension
        
        In the case of May 2, 2019 (which is included in April's schdule)
        we should get "{date_time}_04_0502.json"
    */

    public function testReturnsExpectedFilenameForCopy()
    {
        $date_time = new DateTimeImmutable();
        $original_file_basename = basename(buildPath(__DIR__, "04_0502.json"));

        $expected = buildPath(
            __DIR__,
            $date_time->format(DateTimeImmutable::RFC3339) . "_" . "04_0502.json"
        );
        
        $actual = jsonAssignmentCopyFilename(
            new Destination(__DIR__),
            $date_time,
            $original_file_basename
        );

        $this->assertSame($expected, $actual);
    }
}

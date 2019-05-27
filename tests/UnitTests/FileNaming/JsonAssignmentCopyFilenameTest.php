<?php

namespace StudentAssignmentScheduler\FileNaming\Functions;

use PHPUnit\Framework\TestCase;
use StudentAssignmentScheduler\Destination;
use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use \DateTimeImmutable;

class JsonAssignmentCopyFilenameTest extends TestCase
{
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

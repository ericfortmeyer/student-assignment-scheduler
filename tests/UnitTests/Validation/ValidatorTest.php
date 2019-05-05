<?php

namespace StudentAssignmentScheduler\Validation;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidateFile()
    {
        $pass = "goodFile.php";
        $fail1 = "../../../../../etc/passwd";
        $fail2 = "<?php crazyHack()";
        $fail3 = "php://";

        $this->assertSame(
            $pass,
            Validator::validateFile($pass)
        );

        $this->assertFalse(
            Validator::validateFile($fail1)
        );

        $this->assertFalse(
            Validator::validateFile($fail2)
        );

        $this->assertFalse(
            Validator::validateFile($fail3)
        );
    }
}

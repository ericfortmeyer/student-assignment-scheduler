<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\Resend;

function showManPage(): void
{
    print PHP_EOL;
    print "NAME" . PHP_EOL;
    print "\tresend" . PHP_EOL . PHP_EOL;
    print "Usage:" . PHP_EOL;
    print "\tresend assignments" . PHP_EOL;
    print "\tresend schedule" . PHP_EOL;
    print "\tresend help -- this help page" . PHP_EOL . PHP_EOL;
    print "DESCRIPTION" . PHP_EOL;
    print "\tUse to resend assignment forms and schedules." . PHP_EOL;
    print "\tThe program will prompt you to:" . PHP_EOL;
    print "\t\t(1) Choose what you would like to send [assignment forms or schedules]" . PHP_EOL;
    print "\t\t(2) If you chose assignment forms... select the week that the assignment form falls in." . PHP_EOL;
    print "\t\t(3) If you chose assignment forms... select the assignment in the week you selected." . PHP_EOL;
    print PHP_EOL;
}
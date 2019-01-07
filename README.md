# Student Assignment Scheduler

[![Build Status](https://travis-ci.org/ericfortmeyer/student-assignment-scheduler.svg?branch=master)](https://travis-ci.org/ericfortmeyer/student-assignment-scheduler)
[![Latest Stable Version](https://poser.pugx.org/ericfortmeyer/student-assignment-scheduler/v/stable?format=flat-square)](https://packagist.org/packages/ericfortmeyer/student-assignment-scheduler)
[![Total Downloads](https://poser.pugx.org/ericfortmeyer/student-assignment-scheduler/downloads?format=flat-square)](https://packagist.org/packages/ericfortmeyer/student-assignment-scheduler)
[![License](https://poser.pugx.org/ericfortmeyer/student-assignment-scheduler/license?format=flat-square)](https://packagist.org/packages/ericfortmeyer/student-assignment-scheduler)
[![composer.lock](https://poser.pugx.org/ericfortmeyer/student-assignment-scheduler/composerlock?format=flat-square)](https://packagist.org/packages/ericfortmeyer/student-assignment-scheduler)
#### A way to schedule and email student assignments for the mid-week meeting.

:sunglasses:

### Here's an idea for basic usage
```php
<?php
...

/**
 * Parse pdf schedules into json
 *
 * Data derived from the json schedules are used
 * when the user of the application schedules assignments
 * and for writing out assignment forms
 */
createJsonSchedulesFromWorkbooks(
    $WorkbookParser,
    $path_to_workbooks,
    $path_to_data,
    jsonScheduleCreationNotification()
);

/**
 * Create assignment forms.
 *
 * The json files representing weeks of assignments are used
 * to generate pdf assignment forms.
 */
writeAssignmentForms(
    $AssignmentFormWriter,
    $path_to_json_assignments,
    $path_to_json_schedules,
    $hasScheduleAlreadyBeenCompleted,
    false
);

```

## TODO
- [x] Create Command Line Tool
    - [] Add CLI configuration
- [] Create Web Interface
- [x] Write test


## Want to contribute?

Please [get in touch](e.fortmeyer01@gmail.com)

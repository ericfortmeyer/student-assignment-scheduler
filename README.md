# Student Assignment Scheduler

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

$path_to_workbooks = $path_config["path_to_workbooks"]
    . DIRECTORY_SEPARATOR
    . $config["workbook_format"];

$scheduleCreationNotificationFunc = jsonScheduleCreationNotification();

$SetOfYearsSchedulesWereIn = createJsonSchedulesFromWorkbooks(
    $WorkbookParser,
    $path_to_workbooks,
    $path_config["path_to_data"],
    $scheduleCreationNotificationFunc
);

/**
 * Create assignment forms
 *
 * The json files representing weeks of assignments are used
 * to generate pdf assignment forms
 */
$which_months = writeAssignmentForms(
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

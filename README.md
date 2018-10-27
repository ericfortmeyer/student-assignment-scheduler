# Student Assignment Scheduler

#### A way to schedule and email student assignments for the mid-week meeting.

:sunglasses:

### Here's an idea for basic usage
```php
createJsonSchedulesFromWorkbooks(
    $WorkbookParser,
    $path_config["path_to_workbooks"],
    $path_config["path_to_data"]
);
print green("Schedules were created from workbooks\r\n");



createJsonAssignments(
    "{$path_config["path_to_data"]}/2018",
    "{$path_config["path_to_data"]}/assignments"
);


writeAssignmentForms(
    $AssignmentFormWriter,
    $path_to_json_assignments_files,
    "{$path_config["path_to_data"]}/2018"
);

```

## TODO
- [x] Create Command Line Tool
    - [] Add CLI coniguration
- [] Create Web Interface
- [] Write test :sob:


## Want to contribute?

Please [get in touch](e.fortmeyer01@gmail.com)

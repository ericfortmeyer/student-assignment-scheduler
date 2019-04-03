<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv;

use StudentAssignmentScheduler\Utils\{PdfAssignmentFormWriter, PdfScheduleWriter, MailSender};
use StudentAssignmentScheduler\Classes\ListOfContacts;

use function StudentAssignmentScheduler\Functions\{
    workbookParserImplementation,
    createJsonSchedulesFromWorkbooks,
    sendEmails,
    decryptedPassword,
    importAssignments,
    importSchedule,
    makeRequiredDirectories,
    CLI\writeAssignmentForms,
    CLI\createJsonAssignments,
    CLI\yes,
    CLI\no,
    CLI\red,
    CLI\green,
    CLI\prompt,
    CLI\jsonScheduleCreationNotification,
    CLI\setupContacts,
    CLI\setupScheduleRecipients,
    CLI\setupEmail
};

use StudentAssignmentScheduler\Utils\MWBDownloader\{
    Month,
    Config\DownloadConfig
};

use function StudentAssignmentScheduler\Utils\MWBDownloader\Functions\download;

///////////////////////
//
//   BOOTSTRAPPING
//
//////////////////////

// run installation script if needed
file_exists("vendor")
    || system("sh bin/install.sh");

$autoload_file = file_exists("autoload.php")
    ? "autoload.php"
    : "vendor/autoload.php";

require $autoload_file;

$config_dir = file_exists("config")
    ? "config/"
    : "vendor/ericfortmeyer/student-assignment-scheduler/config/";

// load configuration files
$config_path = $config_dir;
$config_file = "${config_path}config.php";
$config = require $config_file;
$path_config = require "${config_path}path_config.php";
$schedule_recipients_config_file = "${config_path}schedule_recipients.php";
$contacts_file = "${config_path}contacts.php";


/////////////////////////
//
// USER CONFIGURATION
//
/////////////////////////

// the contacts file and schedule recipients must be setup first

// 1. Contacts
// does the user want to setup contacts now
file_exists($contacts_file)
    && !empty($contacts = require $contacts_file)
    || setupContacts($contacts_file)
    && $contacts = require $contacts_file;

// 2. Who should receive the full schedule for the month
// does the user want to setup schedule recipients now
file_exists($schedule_recipients_config_file)
    && !empty($schedule_recipients = require $schedule_recipients_config_file)
    || setupScheduleRecipients($schedule_recipients_config_file)
    && $schedule_recipients = require $schedule_recipients_config_file;


// 3. email configuration
// there must be a .env file with email configuration
$env_dir = __DIR__;
// these fields are required in the .env file
$env_required_fields = [
    "from_email",
    "from_email_password",
    "from_email_nonce",
    "from_email_key",
    "smtp_host"
];


try {
    $Dotenv = new Dotenv($env_dir);
    $Dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    // user interaction
    setupEmail($env_dir);

    $Dotenv = new Dotenv($env_dir);
    $Dotenv->load();
}

$Dotenv->required($env_required_fields);

// 4. make required directories
makeRequiredDirectories($config["make_these_directories"]);

//////////////////////////
//
// INITIALIZE SERVICES
//
//////////////////////////

$WorkbookParser = workbookParserImplementation($config);
$AssignmentFormWriter = new PdfAssignmentFormWriter($config);
$ScheduleWriter = new PdfScheduleWriter($config);
$ListOfContacts = new ListOfContacts($contacts);
$MailSender = new MailSender(
    new PHPMailer(true),
    getenv("from_email"),
    decryptedPassword(),
    getenv("smtp_host")
);



///////////////////////
//
//   INITIALIZE PATHS
//
//////////////////////

$path_to_workbooks = "{$path_config["path_to_workbooks"]}/{$config["workbook_format"]}";
$path_to_data = $path_config["path_to_data"];

/**
 * These strings will be modified by an anonymous function.
 *
 * The final destination of the data is determined dynamically.
 * For example, the year of the schedule may be appended to the path
 * in order to make it the directory where this data is saved.
 */
$path_to_json_schedules = "{$path_config["path_to_data"]}/";
$path_to_json_assignments = "{$path_config["path_to_assignments"]}/";

/**
 * Download the workbook that will be used to make the schedule.
 * 
 * We download the workbooks for the current month and next month if they
 * have not been downloaded yet.
 */

$downloadWorkbookForMonth = function (Month $month) use ($config, $config_file): void {
    download(
        $month,
        new DownloadConfig($config, $config_file)
    );
};

// the current month and following month
$dt = new DateTimeImmutable();
$months = new \Ds\Vector([
    new Month($dt->format("F")),
    new Month($dt->add(new DateInterval("P1M"))->format("F"))
]);

$months->apply($downloadWorkbookForMonth);


/**
 * Parses the workbooks into data that will be required
 * later in the application.
 *
 * The return value of this function is required since
 * the schedule's year is used when creating assignments.
 * The years are used in a 'Set' so that there will be no
 * duplicates.  The last week of December's schedule may be
 * in the following year, in which case both years will
 * be required when making assignments.
 */
$SetOfYearsSchedulesWereIn = createJsonSchedulesFromWorkbooks(
    $WorkbookParser,
    $path_to_workbooks,
    $path_to_data,
    jsonScheduleCreationNotification()
);



/**
 * This function is used to abort creating assignments.
 *
 * An anonymous function is used in order to use variables that
 * are in the parent scope with out requiring partial application.
 */
$path_to_monthly_schedules = $path_config["path_to_schedules"];
$monthly_schedules_file_extension = $config["monthly_schedule_format"];

$monthly_schedule_filename = function (string $month) use (
    $path_to_monthly_schedules,
    $monthly_schedules_file_extension
): string {
    return "${path_to_monthly_schedules}/${month}.${monthly_schedules_file_extension}";
};

$hasScheduleAlreadyBeenCompleted = function (string $month) use ($monthly_schedule_filename) {
    return file_exists($monthly_schedule_filename($month));
};



/**
 * Used to allow the user to create assignments.
 *
 * Most of the UI of the application is in this function.
 *
 * An anonymous function is used in order to use variables that
 * are in the parent scope with out requiring partial application.
 * This function also modifies strings that are in the parent scope
 * by importing references to the strings.
 */

$assignmentsWereMade = false;

$createJsonAssignments = function (
    $carry,
    int $year
) use (
    $AssignmentFormWriter,
    &$path_to_json_schedules,
    &$path_to_json_assignments,
    &$assignmentsWereMade,
    $hasScheduleAlreadyBeenCompleted,
    $ListOfContacts
) {

    // Append the year to the paths
    $path_to_json_schedules .= $year;
    $path_to_json_assignments .= $year;

    /**
     * Interact with the user of the application to schedule assignments.
     *
     * A json file is created for each week of assignments.
     */
     $assignmentsWereMade = createJsonAssignments(
         $path_to_json_schedules,
         $path_to_json_assignments,
         $hasScheduleAlreadyBeenCompleted,
         $ListOfContacts
     );
};



/**
 * Create assignments for each year the schedules are in.
 *
 * The assignment creating function is where most of the
 * user interfacing of the application is.
 */
$SetOfYearsSchedulesWereIn->remove(null);
$SetOfYearsSchedulesWereIn->reduce($createJsonAssignments);



/**
 * Create assignment forms.
 *
 * The json files representing weeks of assignments are used
 * to generate pdf assignment forms.
 */
$year = $SetOfYearsSchedulesWereIn->get(0);

// Abort if assignments were not made
$assignmentsWereMade
    || exit(green("No assignments were made. Good Bye.\r\n"));

$MonthsOfFormsWritten = writeAssignmentForms(
    $AssignmentFormWriter,
    $path_to_json_assignments,
    $path_to_json_schedules,
    $hasScheduleAlreadyBeenCompleted,
    $year
);

// Abort if assignment forms were not written
$MonthsOfFormsWritten->isEmpty()
    && exit(green("It looks like you are all up-to-date.\r\nNo schedules were created.  Good Bye\r\n"));



/**
 * Create the schedule for the month.
 *
 * Uses the json schedule and the json assignment files
 * to generate a schedule (i.e. pdf file) for the month.
 */
$createSchedule = function (string $month) use (
    $ScheduleWriter,
    $path_to_json_assignments,
    $path_to_json_schedules
): string {

    $filename_of_schedule = "${month}.json";
    
    $assignments = importAssignments($month, $path_to_json_assignments);
    $schedule = importSchedule($filename_of_schedule, $path_to_json_schedules);
    
    $schedule_filename = $ScheduleWriter->create($assignments, $schedule, $month);
    return $schedule_filename;
};

/**
 * Email the assignments and schedule.
 *
 * Determine if the user wants to send them.
 */
$emailAssignmentsAndSchedule = function (string $schedule_filename) use (
    $MailSender,
    $ListOfContacts,
    $contacts,
    $config,
    $schedule_recipients
): void {

    $user_response = readline(
        prompt("Do you want to send the emails")
    );

    yes($user_response)
        && sendEmails(
            $MailSender,
            $ListOfContacts,
            $contacts,
            $config["assignment_forms_destination"],
            $schedule_recipients,
            $schedule_filename
        );
    
    no($user_response)
        && print red("Ok. Emails were not sent.\r\n");
};

$MonthsOfFormsWritten
    ->map($createSchedule)
    ->map($emailAssignmentsAndSchedule);

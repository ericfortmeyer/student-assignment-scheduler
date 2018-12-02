<?php

namespace TalkSlipSender\Utils;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use \Ds\Vector;

use function TalkSlipSender\Functions\CLI\doesNotHaveWordVideo;
use function TalkSlipSender\Functions\filenamesByMonth;
use function TalkSlipSender\Functions\shiftFinalWeekInFollowingMonth;
use function TalkSlipSender\Functions\importJson;

class ScheduleWriter
{
    protected const BIBLE_READING = [
        "BIBLE READING",
        "Bible Reading",
        "bible_reading",
        "bible reading"
    ];

    /**
     * @var Fpdi
     */
    protected $pdfCreator;

    /**
     * @var array
     */
    protected $import_args = [
        0,
        0,
        null,
        null,
        true
    ];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var \Closure|null
     */
    protected $importJson;

    /**
     * @var \Closure|null
     */
    protected $writeWeekOfAssignments;

    /**
     * @var \Closure|null
     */
    protected $writeIndividualAssignment;


    public function __construct(array $config)
    {
        $this->config = $config;

        $this->importJson = function (string $path_to_json_assignments): \Closure {
            return function (string $json_file) use ($path_to_json_assignments): array {
                return importJson("${path_to_json_assignments}/${json_file}");
            };
        };

        $this->writeWeekOfAssignments = function (array $schedule): \Closure {
            return function (int $week_index, $week_of_assignments) use ($schedule): void {
                /**
                 * Move to the next page when the 4th week is encountered
                 * since there are only 3 weeks of assignments on the first page
                 */
                if ($week_index === 3) {
                    $this->nextPage();
                }
                $this->writeWeekOfAssignments($week_index, $week_of_assignments, $schedule);
            };
        };

        $this->writeIndividualAssignment = function (int $week_index, string $week_of_assignments): \Closure {
            return function (int $assignment_num, string $assignment_name) use ($week_index, $week_of_assignments): void {
                if (doesNotHaveWordVideo($assignment_name)) {
                    $this->writeStudentAssignment(
                        $week_index,
                        $assignment_num,
                        current($week_of_assignments)
                    );
                    next($week_of_assignments);
                } else {
                    $this->writeStudentAssignment(
                        $week_index,
                        $assignment_num,
                        $this->dataForVideoDiscussion($assignment_name)
                    );
                }
            };
        };
    }
    
    protected function initPdfCreator()
    {
        $this->pdfCreator = new Fpdi();
        $this->textColor("black");
        $this->font($this->config["font"]);
        $this->fontSize($this->config["schedule_font_size"]);
        $this->import($this->config["schedule_template"]);
    }

    /**
     * Create the schedule for the given month
     * 
     * Creates a file with the schedule for the given month that can be distrubted
     * i.e. a PDF file that can be attached to an email
     * @param string $path_to_json_assignments
     * @param string[] $schedule
     * @param string $month
     * @return string
     */
    public function create(
        string $path_to_json_assignments,
        array $schedule,
        string $month
    ): string {
        /**
         * Must do this each time you call the create method.
         * Since the Fpdi object closes the document each time you output a pdf,
         * you will need a new instance of the Fpdi object if you are creating
         * an array of pdf files
         */
        $this->initPdfCreator();

        $partialFunc = $this->writeWeekOfAssignments;
        $writeAssignments = $partialFunc($schedule);
        $schedule_filename = "{$this->config["schedules_destination"]}/{$this->addExtension($month)}";

        $this->preparePDF(
            $writeAssignments,
            array_keys($schedule),
            $this->getArrayOfDataFromJson($month, $path_to_json_assignments)
        );

        $this->createPDF($schedule_filename);

        return $schedule_filename;
    }

    private function preparePDF(\Closure $writeAssignments, array $array_keys_from_schedule, array $schedule_data): void
    {
        array_map(
            $writeAssignments,
            $array_keys_from_schedule,
            $schedule_data
        );
    }
    
    private function getArrayOfDataFromJson(string $month, string $path_to_json_assignments): array
    {
        $partialFunc = $this->importJson;
        $importJson = $partialFunc($path_to_json_assignments);

        $filenames = shiftFinalWeekInFollowingMonth(
            filenamesByMonth($month, $path_to_json_assignments)
        );

        return (new Vector($filenames))->map($importJson)->toArray();
    }

    /**
     * Prepares the schedule file for output
     * 
     * Loads the PDF writing object with items that need to be written to final output.
     * Uses:
     * (1) the zero-based index of the week that is represented by the data
     * (2) an array of assignments for the given week
     * (3) an array mapping the title of the assignments to a numeric representation
     * @example $this->writeWeekOfAssignments(2, [$assn1, $assn2, ...], [5 => 'First Return Visit', ...])
     * 
     * This method is public for testing
     * 
     * @param int $week_index
     * @param array $week_of_assignments
     * @param array $assignment_map
     * @return void
     */
    public function writeWeekOfAssignments(
        int $week_index,
        array $week_of_assignments,
        array $assignment_map
    ): void {

        $this->writeDate($week_index, $week_of_assignments[0]["date"]);

        $partialFunc = $this->writeIndividualAssignment;
        $partialFunc($week_index, $week_of_assignments);

        $MapOfAssignments = new \Ds\Map($assignment_map);
        $MapOfAssignments->put(4, "bible_reading");
        $MapOfAssignments->has("date") && $MapOfAssignments->remove("date");
        $MapOfAssignments->ksort();
        $MapOfAssignments->map($writeAssignments);
    }

    protected function dataForVideoDiscussion(string $assignment): array
    {
        return [
            "assignment" => $assignment,
            "name" => "",
            "assistant" => "",
            "counsel_point" => ""
        ];
    }

    protected function writeStudentAssignment(
        int $week_index,
        int $assignment_num,
        array $data
    ): void {

        $this->notBibleReading($data["assignment"])
            && $this->writeAssignment(
                $week_index,
                $assignment_num,
                $data["assignment"]
            );

        $this->writeStudentAndAssistantAndCounselPoint(
            $week_index,
            $assignment_num,
            $data["name"],
            $data["assistant"],
            $data["counsel_point"]
        );
    }

    protected function writeAssignment(int $week_index, int $assignment_num, string $assignment): void
    {
        $this->position(
            $week_index,
            $assignment_num,
            "position"
        );

        $this->write($assignment);
    }

    protected function writeStudentAndAssistantAndCounselPoint(
        int $week_index,
        int $assignment_num,
        string $student,
        string $assistant,
        string $counsel_point
    ): void {
        $assistant
            ? $this->writeName(
                $week_index,
                $assignment_num,
                $this->appendCounselPoint(
                    $this->appendAssistantName($student, $assistant),
                    $counsel_point
                )
            )
            : $this->writeName(
                $week_index,
                $assignment_num,
                $this->appendCounselPoint(
                    $student,
                    $counsel_point
                )
            );
    }

    protected function writeStudentAndAssistant(
        int $week_index,
        int $assignment_num,
        string $student,
        string $assistant
    ): void {
        $assistant
            ? $this->writeName(
                $week_index,
                $assignment_num,
                $this->appendAssistantName($student, $assistant)
            )
            : $this->writeName(
                $week_index,
                $assignment_num,
                $student
            );
    }

    protected function writeName(int $week_index, int $assignment_num, string $name): void
    {
        $this->position(
            $week_index,
            $assignment_num,
            "name"
        );
        $this->write($name);
    }

    protected function appendAssistantName(string $student, string $assistant): string
    {
        return "${student}{$this->withSlash($assistant)}";
    }

    protected function appendCounselPoint(string $name, string $counsel_point): string
    {
        return "${name} ${counsel_point}";
    }

    protected function writeAssistant(string $name_of_assistant): void
    {
        $this->write("{$this->withSlash($name_of_assistant)}");
    }

    protected function withSlash(string $name): string
    {
        return "/${name}";
    }

    protected function writeDate(int $week_index, string $date): void
    {
        $this->position(
            $week_index,
            0,
            "date"
        );
        $this->write($date);
    }

    protected function writeCounselPoint(int $week_index, int $assignment_num, string $counsel_point): void
    {
        $this->position(
            $week_index,
            $assignment_num,
            "counsel_point"
        );
        $this->write($counsel_point);
    }

    protected function createPDF(string $filename): void
    {
        $this->pdfCreator->Output(
            "F",
            $filename,
            true
        );
    }

    protected function notBibleReading(string $assignment): bool
    {
        return !in_array($assignment, self::BIBLE_READING);
    }

    protected function addExtension(string $basename): string
    {
        return "$basename.pdf";
    }

    protected function removeExtension(string $filename): string
    {
        return str_replace(".pdf", "", $filename);
    }

    protected function allCaps(string $string): string
    {
        return strtoupper($string);
    }

    protected function monthFromDate(string $date): string
    {
        return date_create_from_format("F j", $date)->format("F");
    }

    protected function firstName(string $fullname): string
    {
        return current(
            explode(
                " ",
                $fullname
            )
        );
    }

    protected function position(int $week_index, int $assignment_num, string $position): void
    {
        $this->pdfCreator->SetXY(
            ...$this->setXYFromConfig($week_index, $assignment_num, $position)
        );
    }

    protected function setXYFromConfig(int $week_index, int $assignment_num, string $which_position): array
    {
        $week_config = $this->config["schedule"]["week"][$week_index];

        return $which_position === "date"
            ? $week_config[$which_position]
            : $week_config[$assignment_num][$which_position];
    }

    protected function write(string $string): void
    {
        $this->pdfCreator->Write(0, $string);
    }

    public function font(string $font): void
    {
        $this->pdfCreator->SetFont($font);
    }

    public function fontSize(int $points): void
    {
        $this->pdfCreator->SetFontSize($points);
    }

    public function textColor(string $color): void
    {
        $rgb = $this->colorIsAvailable($color)
            ? $this->toRgb($color)
            : $this->toRgb($this->config["font_color"]);


        $this->pdfCreator->setTextColor(...$rgb);
    }

    protected function colorIsAvailable(string $color): bool
    {
        return key_exists(
            $color,
            $this->config["colors"]
        );
    }

    protected function toRgb(string $color): array
    {
        return $this->config["colors"][$color];
    }

    protected function import(string $path_to_template): void
    {
        $this->pdfCreator->AddPage();
        $this->pdfCreator->setSourceFile(StreamReader::createByFile($path_to_template));
        $this->pdfCreator->useImportedPage(
            $this->pdfCreator->importPage(1),
            ...$this->import_args
        );
    }
    
    protected function nextPage(): void
    {
        $this->pdfCreator->AddPage();
        $this->pdfCreator->useImportedPage(
            $this->pdfCreator->importPage(2),
            ...$this->import_args
        );
    }
}

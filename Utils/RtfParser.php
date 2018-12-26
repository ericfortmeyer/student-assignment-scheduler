<?php

namespace StudentAssignmentScheduler\Utils;

use \Ds\Vector;
use \Ds\Map;
use function StudentAssignmentScheduler\Functions\getAssignmentDate;

class RtfParser implements ParserInterface
{
    protected const FILE_TYPE = "rtf";

    /**
     * @var string
     */
    protected $meeting_night = "";

    public function __construct(string $meeting_night)
    {
        $this->meeting_night = $meeting_night;
    }

    /**
     * Wrap the text in a DocumentWrapper
     *
     * @param string $directory
     * @return DocumentWrapper
     */
    public function parseFile(string $directory): DocumentWrapper
    {
        return new DocumentWrapper($this->parse($directory));
    }

    /**
     * Day of the month and assignments
     *
     * The keys of the assignments correspond to
     * their assignment numbers on the worksheet
     *
     * @param string $textFromWorksheet
     * @param string $month
     * @return array
     */
    public function getAssignments(string $textFromWorksheet, string $month): array
    {
        $parse_config = $this->getConfig();
        $date_pattern_func = $parse_config["assignment_date_pattern_func"];
        $assignment_pattern = $parse_config["rtf_assignment_pattern"];
        $justTextWithAssignments = $parse_config["rtf_just_text_with_assignments_func"];
        $interval_spec = $parse_config["interval_spec"][$this->meeting_night];

        $day_of_month = getAssignmentDate($date_pattern_func($month), $textFromWorksheet, $month, $interval_spec);

        $mapWithDate = new Map(["date" => $day_of_month]);
        $assignmentsMap = $this->assignments($assignment_pattern, $justTextWithAssignments($textFromWorksheet));

        return $mapWithDate->union($assignmentsMap)->toArray();
    }

    /**
     * A vector of page numbers required when creating a document representing the file parsed
     *
     * @param $filename
     * @return Vector
     */
    public function pageNumbers(string $filename): Vector
    {
        $directory = $filename;
        return new Vector($this->zeroIndexedRangeOfPageNumbers($directory));
    }
    
    /**
     * The assignments with their assignment numbers as keys
     *
     * Use a regular expresssion pattern to find the assignments in the text
     *
     * @param string $assignment_pattern
     * @param string $textFromWorksheet
     * @return Map
     */
    protected function assignments(string $assignment_pattern, string $textFromWorksheet): Map
    {
        preg_match_all($assignment_pattern, $textFromWorksheet, $matches);

        $assignments = $matches[0];
        //skip bible reading
        $first_assignment_num = 5;

        return $this->mapAssignmentsToWorksheetAssignmentNumbers($first_assignment_num, $assignments);
    }
    
    /**
     * Set the keys of all assignments to their assignment number in the worksheet.
     *
     * Rtf documents do not include the assignment number in the text.
     *
     * @param int $first_assignment_num
     * @param array $assignments
     * @return Map
     */
    protected function mapAssignmentsToWorksheetAssignmentNumbers(int $first_assignment_num, array $assignments): Map
    {
        $map = new Map();
        $key = $first_assignment_num;

        foreach ($assignments as $assignment) {
            $map->put($key, $assignment);
            $key++;
        }

        return $map;
    }

    /**
     * Configuration containing regular expressions needed to parse data
     *
     * Use a configuration file for regexp patterns so that the patterns
     * required by all parsers can be located in the same place
     *
     * @return array
     */
    protected function getConfig(): array
    {
        return require "parse_config.php";
    }

    /**
     * Get a RtfDocument instance containing the contents of all files in the directory
     *
     * @param string $directory
     * @return RtfDocument
     */
    protected function parse(string $directory): RtfDocument
    {
        $pages = $this->contentOfAllFiles(
            $this->justWeeks($this->filenames($directory)),
            $directory
        );

        return new RtfDocument($pages, $directory);
    }

    public function zeroIndexedRangeOfPageNumbers(string $directory): array
    {
        $end = count($this->justWeeks($this->filenames($directory))) - 1;

        return range(0, $end);
    }

    protected function justWeeks(array $filenames): array
    {
        return $this->removeSampleConversations($filenames);
    }

    protected function filenames(string $directory): array
    {
        return array_diff(scandir($directory), [".", "..", ".DS_Store"]);
    }

    protected function removeSampleConversations(array $filenames): array
    {
        // remove the filename that ends in 00
        return preg_grep(
            "/\d{6}_0[^0]+/",
            $filenames
        );
    }

    /**
     * Get the contents of all files
     *
     * @todo Verify file contents in file registry
     * @param array $filenames
     * @param string $directory
     * @return array
     */
    protected function contentOfAllFiles(array $filenames, string $directory): array
    {
        $getContents = function (string $filename) use ($directory) {
            return file_get_contents("${directory}/${filename}");
        };

        // use vector to reset indexes
        $vector = new Vector($filenames);

        return $vector->map($getContents)->toArray();
    }

    public function getFileType(): string
    {
        return self::FILE_TYPE;
    }
}

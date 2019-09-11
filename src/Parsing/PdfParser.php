<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Parsing;

use Smalot\PdfParser\Parser;
use \Ds\Map;
use \Ds\Vector;

/**
 * Use to parse a pdf schedule.
 *
 * @codeCoverageIgnore
 */
final class PdfParser implements ParserInterface
{
    protected const FILE_TYPE = "pdf";

    /**
     * @var Parser|null
     */
    protected $parser;

    /**
     * @var string
     */
    protected $meeting_night = "";

    public function __construct(Parser $parser, string $meeting_night)
    {
        $this->parser = $parser;
        $this->meeting_night = $meeting_night;
    }

    public function parseFile(string $filename): DocumentWrapper
    {
        /**
         * Repress errors since I'm using a third party library for pdf parsing
         * that throws a warning in PHP 7.3.
         *
         * The error is:
         * "continue" targeting switch is equivalent to "break". Did you mean to use "continue 2"?
         */
        $initial_error_reporting_level = ini_get("error_reporting");
        error_reporting(0);
        \trigger_error('hey');

        $contents = $this->parser->parseFile($filename);

        // restore error reporting level
        error_reporting($initial_error_reporting_level);
        
        return new DocumentWrapper($contents);
    }

    public function getAssignments(string $textFromWorksheet, string $month): array
    {
        
        $parse_config = $this->getConfig();
        $pattern_func = $parse_config["pdf_assignment_pattern_func"];
        $assignment_date_pattern_func = $parse_config["assignment_date_pattern_func"];
        $interval_spec = $parse_config["interval_spec"][$this->meeting_night];
    
        $map = new Map();
        $map->put(
            "date",
            Functions\getAssignmentDate(
                $assignment_date_pattern_func($month),
                $textFromWorksheet,
                $month,
                $interval_spec
            )
        );
        $map->put(5, $this->getAssignment($pattern_func(5), $textFromWorksheet));
        $map->put(6, $this->getAssignment($pattern_func(6), $textFromWorksheet));
        $map->put(7, $this->getAssignment($pattern_func(7), $textFromWorksheet));

        return $map->toArray();
    }

    public function pageNumbers(string $filename = ""): Vector
    {
        return new Vector(range(1, 6));
    }

    protected function getAssignment(string $pattern, string $text): string
    {
        $string_representation_of_media_image_for_videos = "w";
        $result = ltrim(
            Functions\parse(
                $pattern,
                $text
            ),
            $string_representation_of_media_image_for_videos
        );
        return $result === "Ta l k"
            ? str_replace(" ", "", $result)
            : $result;
    }
        
    protected function getConfig(): array
    {
        return include "parse_config.php";
    }

    public function getErrorMsg(string $context): string
    {
        $path = $context;
        return "It looks like the workbooks haven't been downloaded to ${path} yet." . PHP_EOL
            . "Make sure that the workbooks, which should be " . self::FILE_TYPE . " files"
            . " and should have their original filenames,"
            . " are located in ${path}" . PHP_EOL;
    }
}

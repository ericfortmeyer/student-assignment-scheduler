<?php

namespace TalkSlipSender\Utils;

use \Ds\Vector;

interface ParserInterface
{
    /**
     * Creates a document representation by parsing the file or files in a directory.
     *
     * A DocumentWrapper is created so that the application can use third party libraries
     * without depending on their implementation.
     *
     * @param string $filename A file or a directory of files needing to be parsed
     * @return DocumentWrapper Wraps the document representation produced by the parser
     *     to ensure compatibility with other libraries.
     */
    public function parseFile(string $filename): DocumentWrapper;

    /**
     * Determines how many pages the resulting document representation should have.
     *
     * @param string $filename A file or a directory of files needing to be parsed.
     * @return Vector The page numbers of the document.
     */
    public function pageNumbers(string $filename): Vector;
    
    /**
     * Creates an array representing data parsed from the text.
     *
     * Providing the schedules month helps to ensure that dates which are a part of
     * the data required will be accurate.
     *
     * @param string $textFromWorksheet Text parsed from the worksheet.
     * @param string $month The month of the worksheet.
     * @return array Data parsed from the text.
     */
    public function getAssignments(string $textFromWorksheet, string $month): array;
}

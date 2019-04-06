<?php

namespace StudentAssignmentScheduler\Functions\Localization\Language\PublicationReferences;

use StudentAssignmentScheduler\Classes\Language;
// use const StudentAssignmentScheduler\WORKBOOK_ABBR;

const PREFIXES = [
    Language::ASL => "mwb" . "_" . Language::ASL . "_"
];

function worksheetFilenamePrefix(string $meeting_language): string
{
    return PREFIXES[$meeting_language];
}

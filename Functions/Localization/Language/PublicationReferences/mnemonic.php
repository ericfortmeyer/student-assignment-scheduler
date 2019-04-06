<?php

namespace StudentAssignmentScheduler\Functions\Localization\Language\PublicationReferences;

use StudentAssignmentScheduler\Classes\Language;
// use const StudentAssignmentScheduler\WORKBOOK_ABBR;

const MNEMONICS = [
    Language::ASL => "mwb" . "sl",
    Language::ENGLISH => "mwb"
];

function mnemonic(string $meeting_language): string
{
    return MNEMONICS[$meeting_language];
}

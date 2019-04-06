<?php

namespace StudentAssignmentScheduler\Functions\Localization\Language\PublicationReferences;

use StudentAssignmentScheduler\Classes\Language;


const ASSIGNMENT_FORM_NAME = "S-89";

function assignmentForm(string $written_language, string $path_to_forms): string
{
    $filetype = "pdf";
    $suffixes = [
        Language::ENGLISH => "E",
        Language::SPANISH => "S"
    ];
    
    return "${path_to_forms}/" . ASSIGNMENT_FORM_NAME . "-{$suffixes[$written_language]}.${filetype}";
}

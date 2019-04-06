<?php

namespace StudentAssignmentScheduler\Functions\Localization\Language\PublicationReferences;

use StudentAssignmentScheduler\Classes\Language;

const SCHEDULE_TEMPLATE_NAME = "S-140";

function scheduleTemplate(string $written_language, string $path_to_forms): string
{
    $filetype = "pdf";
    $suffixes = [
        Language::ENGLISH => "E",
        Language::SPANISH => "S"
    ];

    return "${path_to_forms}/" . SCHEDULE_TEMPLATE_NAME
        . "-{$suffixes[$written_language]}.${filetype}";
}

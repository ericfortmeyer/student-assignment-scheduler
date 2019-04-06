<?php

namespace StudentAssignmentScheduler\Functions\Localization\Language\DateTime;

use StudentAssignmentScheduler\Classes\Language;
use StudentAssignmentScheduler\Functions\Localization\Language\LanguageNotSetupException;

const LOCALES = [
    Language::ENGLISH => "en_US",
    Language::SPANISH => "es_ES"
];

function dateLocalized(string $date, string $written_language, string $date_format): string
{
    $languageHasNotBeenSetupYet = !\key_exists($written_language, LOCALES);


    if ($languageHasNotBeenSetupYet) {
        throw new LanguageNotSetupException($written_language);
    }
    
    setlocale(LC_TIME, LOCALES[$written_language]);
    return strftime($date_format, strtotime($date));
}

<?php

namespace StudentAssignmentScheduler\Functions\Localization\Language;

final class LanguageNotSetupException extends \RuntimeException
{
    public function __construct(string $language)
    {
        $this->message = "So... ${language} hasn't been setup yet."
            . "Please let the contributors of the project know "
            . "that you need ${language} setup for localization";
    }
}

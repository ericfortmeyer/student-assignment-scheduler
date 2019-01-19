<?php

namespace StudentAssignmentScheduler\Utils;

class RtfPage
{
    /**
     * @var string
     */
    protected $text = "";

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->withBackwardsCompatibleDateAppended($this->text);
    }

    protected function withBackwardsCompatibleDateAppended(string $text): string
    {
        $backwards_compatible_date = implode(" ", $this->parseDate($text));
        
        return $text . $backwards_compatible_date;
    }

    protected function parseDate(string $text): array
    {
        $date = "/\\\\b\s{1}(\w{4,9})\\\\u160\?(\d{1,2})(?:-|\\\\u8211\?)(?:[\w]{4,9}|\d{1,2})/";

        preg_match($date, $text, $matches);

        return [
            // prepend the newline to be compatible with pdf parser
            "month" => "\n" . strtoupper($matches[1]),
            "day" => $matches[2]
        ];
    }
}

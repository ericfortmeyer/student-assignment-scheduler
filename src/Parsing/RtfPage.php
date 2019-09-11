<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\Parsing;

/**
 * Represents a page from a Rtf document
 */
class RtfPage
{
    /**
     * @var string
     */
    protected $content = "";

    /**
     * Create instance.
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->withBackwardsCompatibleDateAppended($this->content);
    }

    /**
     * @param string $content
     * @return string
     */
    protected function withBackwardsCompatibleDateAppended(string $content): string
    {
        $backwards_compatible_date = implode(" ", $this->parseDate($content));
        return "${content}${backwards_compatible_date}";
    }

    /**
     * @param string $content
     * @return array<string,string>
     */
    protected function parseDate(string $content): array
    {
        $date = "/\\\\b\s{1}(\w{3,9})\\\\u160\?(\d{1,2})(?:-|\\\\u8211\?)(?:[\w]{3,9}|\d{1,2})/";
        preg_match($date, $content, $matches);
        return [
            // prepend the newline to be compatible with pdf parser
            "month" => "\n" . strtoupper($matches[1]),
            "day" => $matches[2]
        ];
    }
}

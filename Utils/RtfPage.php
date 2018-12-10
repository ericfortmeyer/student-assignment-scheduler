<?php

namespace TalkSlipSender\Utils;

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
        $date = "/(\w+)\S{6}(\d{1,2})-\d{1,2}/";

        preg_match($date, $text, $matches);

        return [
            "month" => strtoupper($matches[0]),
            "day" => $matches[1]
        ];
    }
}

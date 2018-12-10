<?php

namespace TalkSlipSender\Utils;

use function TalkSlipSender\Functions\getConfig;
use function TalkSlipSender\Functions\getYearFromWorkbookPath;
use function TalkSlipSender\Functions\getMonthFromWorkbookPath;

/**
 * Use this class for polymorphism when parsing documents
 *
 * This class shares methods with the Document class
 * of a 3rd party library used in this project.
 * The goal is to produce the same results no matter what type of
 * docuement is being parsed in order to provide flexibilty.
 */
class RtfDocument
{
    /**
     * @var array<int,RtfPage>
     */
    protected $pages = [];
    
    /**
     * @var string
     */
    protected $filename = "";

    public function __construct(array $pages, string $filename)
    {
        $this->setPages($pages);
        $this->filename = $filename;
    }

    protected function setPages(array $pages): void
    {
        $this->pages = array_map(
            function (string $text) {
                return new RtfPage($text);
            },
            $pages
        );
    }

    /**
     * Must return an array of RtfPages
     *
     * @return array<int,RtfPages>
     */
    public function getPages(): array
    {
        return $this->pages;
    }

    public function getDetails(): array
    {
        $config = getConfig();
        $language = $config["language"];
        $mnemonic = $config["mnemonic"][$language];
        //keep the result compatible with the result of parsing pdf files
        return [
            "Title" => "$mnemonic{$this->year()}.{$this->month()}"
        ];
    }

    /**
     * Return a two digit representation of the year
     *
     * @return string
     */
    protected function year(): string
    {
        return getYearFromWorkbookPath($this->filename);
    }

    /**
     * Return a two digit representation of the month
     *
     * @return string
     */
    protected function month(): string
    {
        return getMonthFromWorkbookPath($this->filename);
    }
}

<?php

namespace TalkSlipSender\Utils;

use \Ds\Vector;

/**
 * Wraps all contents of an rtf file in a DocumentWrapper object
 * 
 * This class does not parse the text of the document.
 * It is used for polymorphism.
 */
class RtfParser implements ParserInterface
{
    /**
     * Wrap the text in a DocumentWrapper
     * 
     * @param string $filename
     * @return DocumentWrapper
     */
    public function parseFile(string $directory): DocumentWrapper
    {
        return new DocumentWrapper($this->parse($directory));
    }

    /**
     * Get a RtfDocument instance containing the contents of all files in the directory
     * 
     * @param string $directory
     * @return RtfDocument
     */
    protected function parse(string $directory): RtfDocument
    {
        $filenames = array_diff(scandir($directory, [".", "..", ".DS_Store"]));
        $justWeeks = $this->removeSampleConversations($filenames);
        $pages = $this->contentOfAllFiles($justWeeks, $directory);

        return new RtfDocument($pages, $directory);
    }

    protected function removeSampleConversations(array $filenames): array
    {
        // remove the filename that ends in 00
        return preg_grep(
            "/\d{6}_0[^0]+/",
            $filenames
        );
    }

    protected function contentOfAllFiles(array $filenames, string $directory): array
    {
        $getContents = function (string $filename) use ($directory) {
            return file_get_contents("${directory}/${filename}");
        };

        // use vector to reset indexes
        $vector = new Vector($filenames);

        return $vector->map($getContents)->toArray();
    }
}

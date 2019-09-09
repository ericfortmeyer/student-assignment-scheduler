<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

final class Filetype
{
    private const VALID_FILETYPES = [
        "rtf",
        "pdf"
    ];

    /**
     * @var string $value
     */
    private $value = "";

    private $path_to_config_file;

    public function __construct(string $filetype, string $path_to_config_file = "")
    {
        $this->path_to_config_file = $path_to_config_file;

        $this->completeConstructionOnlyIfFiletypeIsValid($filetype);
    }

    private function completeConstructionOnlyIfFiletypeIsValid(string $filetype)
    {
        if ($this->validateFiletype($filetype)) {
            $this->value = $filetype;
        }
    }

    public function toString()
    {
        return $this->value;
    }

    /**
     * Validate that the filetype specified in the configuration
     * is among expected filetypes.
     * 
     * @codeCoverageIgnore
     * @throws InvalidFiletypeException
     * @return bool
     */
    private function validateFiletype(string $filetype): bool
    {
        if (!in_array(strtolower($filetype), self::VALID_FILETYPES)) {
            throw new InvalidFiletypeException(
                "{$filetype} is not among expected filetypes."
                    . PHP_EOL . "Expected filetypes: " . json_encode(self::VALID_FILETYPES)
                    . PHP_EOL . "Check configuration in {$this->path_to_config_file}"
            );
        } else {
            return true;
        }
    }
}

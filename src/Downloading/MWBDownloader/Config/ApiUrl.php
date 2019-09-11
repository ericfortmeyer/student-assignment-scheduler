<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

final class ApiUrl
{
    /**
     * @var string $value
     */
    private $value = "";

    /**
     * @var string $params
     */
    private $params = "";

    /**
     * @var string $path_to_config_file
     */
    private $path_to_config_file = "";

    public function __construct(string $url, string $path_to_config_file = "")
    {
        $this->path_to_config_file = $path_to_config_file;

        $this->completeConstructionOnlyIfUrlIsValid($url);
    }
    
    private function completeConstructionOnlyIfUrlIsValid(string $url)
    {
        $this->validateUrl($url) && $this->value = $url;
    }

    public function __toString()
    {
        return !empty($this->params)
            ? "{$this->value}?{$this->params}"
            : $this->value;
    }

    /**
     * Validate the url of the api
     * @codeCoverageIgnore
     * @throws InvalidApiUrlException
     * @param string $url
     * @return bool
     */
    private function validateUrl(string $url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            throw new InvalidApiUrlException(
                "{$url} does not appear to be a valid url."
                    . PHP_EOL . "Check configuration in {$this->path_to_config_file}"
            );
        } else {
            return true;
        }
    }

    public function withParams(array $params): self
    {
        $clone = clone $this;
        $clone->params = http_build_query($params);

        return $clone;
    }
}

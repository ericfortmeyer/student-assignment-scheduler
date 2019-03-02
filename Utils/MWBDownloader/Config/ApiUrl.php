<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Config;

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

    private $path_to_config_file;

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
     *
     * @throws InvalidConfigurationException
     * @param string $url
     * @return bool
     */
    private function validateUrl(string $url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) :
            throw new InvalidConfigurationException(
                "{$url} does not appear to be a valid url."
                    . PHP_EOL . "Check configuration in {$this->path_to_config_file}"
            );
        else :
            return true;
        endif;
    }
    public function withParams(array $params): self
    {
        $clone = clone $this;
        $clone->params = http_build_query($params);

        return $clone;
    }
}

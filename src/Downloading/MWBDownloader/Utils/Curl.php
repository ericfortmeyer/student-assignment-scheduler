<?php

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Utils;

use StudentAssignmentScheduler\Downloading\MWBDownloader\Config\ConfigArrayValue;

/**
 * Encapsulates all option setting, function calls, and error handling
 * provided by PHP's native curl library.
 */
final class Curl
{
    private static function resultHandlingMap(): array
    {
        return [
            0 => function (bool $result, string $error) {
                throw new InvalidUrlException($error);
            },
            500 => function ($result, string $error) {
                throw new ServerFailureException($error);
            },
            200 => function ($result) {
                return $result;
            },
            404 => function ($result, string $error) {
                throw new PageNotFoundException($error);
            },
            400 => function ($result, string $error) {
                throw new BadRequestException($error);
            }
        ];
    }

    /**
     * Return result on success, handle errors on failure.
     *
     * @suppress PhanTypeArrayAccess
     * @param mixed $result Typically a string on success, false on failure
     * @param int $response_code
     * @param string $last_error
     * @return string
     */
    private static function handleResult($result, int $response_code, string $last_error): string
    {
        return self::resultHandlingMap()[$response_code]($result, $last_error);
    }

    private static function setOpts(&$curl, ConfigArrayValue $config)
    {
        $opts = $config->toArray();

        $result = curl_setopt_array($curl, $opts);

        if ($result === false) {
            throw new \RuntimeException("Check your curl options." . PHP_EOL . "Curl Error" . curl_error($curl));
        }
    }

    public function __invoke(ConfigArrayValue $opts)
    {
        $ch = curl_init();
        
        self::setOpts($ch, $opts);

        $result = curl_exec($ch);
        
        $response_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        
        $last_error = curl_error($ch);

        $errorMessage = empty($last_error)
            ? "Url was {$opts[CURLOPT_URL]}"
            : $last_error;
        
        curl_close($ch);
        
        return self::handleResult($result, $response_code, $errorMessage);
    }
}

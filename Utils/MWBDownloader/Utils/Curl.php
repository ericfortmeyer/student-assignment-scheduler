<?php

namespace StudentAssignmentScheduler\Utils\MWBDownloader\Utils;

use StudentAssignmentScheduler\Utils\MWBDownloader\Config\ConfigArrayValue;

final class Curl
{
    private static function resultHandlingMap(): array
    {
        return [
            // boolean converts to int keys
            0 => function ($result, string $error) {
                throw new \RuntimeException(
                    "Session Failure."
                        . PHP_EOL
                        . "Curl Error: $error"
                );
            },
            1 => function ($result) {
                return $result;
            },
            404 => function ($code) {
                throw new \Exception(
                    "Page not found"
                    . PHP_EOL
                );
            }
        ];
    }

    private static function handleResult($result, int $response_code, string $last_error)
    {
        $resultHandlingMap = self::resultHandlingMap();
        $resultKey = (int) (bool) $result;

        array_key_exists($response_code, $resultHandlingMap)
            && $resultHandlingMap[$response_code]($result, $last_error);

        return $resultHandlingMap[$resultKey]($result, $last_error);
    }

    private static function setOpts(&$curl, ConfigArrayValue $config)
    {
        $opts = $config->toArray();

        $result = curl_setopt_array($curl, $opts);

        if ($result === false) {
            throw new \RuntimeException("Check your curl options." . PHP_EOL . "Curl Error" . curl_error($curl));
        }
    }

    public function __invoke(string $url, ConfigArrayValue $opts)
    {
        $ch = curl_init();
        
        self::setOpts($ch, $opts);

        $info = curl_getinfo($ch);
        
        $result = curl_exec($ch);
        
        $response_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        
        $last_error = curl_error($ch);
        
        curl_close($ch);
        
        return self::handleResult($result, $response_code, $last_error);
    }
}

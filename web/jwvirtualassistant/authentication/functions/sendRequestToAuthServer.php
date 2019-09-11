<?php declare(strict_types=1);

/**
 * Forward the post data to the server.
 * 
 * @throws \RuntimeException
 * @param array $post_data
 * @return string the response
 */
function sendRequestToAuthServer($post_data): string {
    try {
        $url = getConfigValue("auth_url");
        $ch = curl_init($url);
        $opts = [
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_RETURNTRANSFER => true
        ];
        $result = curl_setopt_array($ch, $opts);
        if ($result === false) {
            throw new \RuntimeException("Check your curl options." . PHP_EOL . "Curl Error" . curl_error($curl));
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

    } catch (\Throwable $e) {
        return $e->getMessage();
    }
}

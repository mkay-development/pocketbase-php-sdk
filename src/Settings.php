<?php

namespace Pb;

/**
 *
 */
class Settings
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private static string $token = '';

    /**
     * @param string $url
     * @param string $collection
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param string $recordId
     * @param string $url
     * @param string $method
     * @return bool|string
     */
    public function doRequest(string $url, string $method, $bodyParams = []): string
    {
        $ch = curl_init();

        if (self::$token != '') {
            $headers = array(
                'Content-Type:application/json',
                'Authorization: ' . self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($bodyParams) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyParams);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * @return void
     */
    public function getAll(){

    }
}
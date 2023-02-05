<?php

namepspace \pb;
class Client
{
    private string $response;
    private string $url;

    public function __construct(string $url)
    {
        $this->response = '{}';
        $this->url = $url;
    }

    public function collection(string $collection, int $page = 1)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url."/api/collections/".$collection."/records?page=".$page);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $this->response = curl_exec($ch);
        curl_close($ch);

        return json_decode($this->response, JSON_FORCE_OBJECT);
    }

}

<?php

namespace Pb;

class Client
{
    private string $response;
    private string $url;

    public function __construct(string $url)
    {
        $this->response = '{}';
        $this->url = $url;
        $this->users = [];
    }

    public function collection(string $collection, int $page = 1)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url."/api/collections/".$collection."/records?page=".$page);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $collection = new Collection(curl_exec($ch));
        curl_close($ch);

        return json_decode($collection, JSON_FORCE_OBJECT);
    }
}

<?php

class UsersCollection
{
    private string $url;
    private string $collection;

    public function __construct(string $url, string $collection)
    {
        $this->url = $url;
        $this->collection = $collection;
    }

    public function getList($page = 1, $perPage = 30)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/users/records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, JSON_FORCE_OBJECT);
    }

    public function authWithPassword()
    {
        var_dump('try auth');
    }
}

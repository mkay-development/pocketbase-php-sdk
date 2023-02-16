<?php

namespace Pb;

class Collection
{
    private string $collection;
    private string $url;


    public function __construct(string $url, string $collection)
    {
        $this->url = $url;
        $this->collection = $collection;
    }

    public function getFullList(int $batch = 200, array $queryParams = []){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/".$this->collection."/records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, JSON_FORCE_OBJECT);
    }

    public function getFirstListItem(string $filter, array $queryParams = []){

    }

    public function create(array  $bodyParams = [], array $queryParams = []){

    }
    public function  update(string $recordId, array $bodyParams = [],array $queryParams = []){

    }
    public function delete(string $recordId, array $queryParams = []){

    }

    public function getOne(string $recordId, array $queryParams = []){

    }

    public function authWithPassword()
    {
        $data = json_decode($this->json, JSON_FORCE_OBJECT);
        var_dump($data);
    }
}

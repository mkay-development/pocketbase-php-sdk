<?php

namespace Pb;

class Collection
{
    private string $collection;
    private string $url;
    private static string $token = '';


    public function __construct(string $url, string $collection)
    {
        $this->url = $url;
        $this->collection = $collection;
    }

    public function getFullList(int $batch = 200, array $queryParams = []){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/".$this->collection."/records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(self::$token != ''){
            $headers = array(
                'Content-Type:application/json',
                'Authorization: '.self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, JSON_FORCE_OBJECT);
    }

    public function getFirstListItem(string $filter, array $queryParams = []){

    }

    public function  create(array $bodyParams = [],array $queryParams = []){
        $ch = curl_init();

        if(self::$token != ''){
            $headers = array(
                'Content-Type:application/json',
                'Authorization: '.self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/".$this->collection."/records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyParams));
        $output = curl_exec($ch);
        var_dump($output);
        curl_close($ch);
    }

    public function  update(string $recordId, array $bodyParams = [],array $queryParams = []){
        $ch = curl_init();

        if(self::$token != ''){
            $headers = array(
                'Content-Type:application/json',
                'Authorization: '.self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/".$this->collection."/records/".$recordId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyParams));
        $output = curl_exec($ch);
        var_dump($output);
        curl_close($ch);
    }
    public function delete(string $recordId, array $queryParams = []){
        $ch = curl_init();

        if(self::$token != ''){
            $headers = array(
                'Content-Type:application/json',
                'Authorization: '.self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/".$this->collection."/records/".$recordId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $output = curl_exec($ch);
        curl_close($ch);
    }

    public function getOne(string $recordId, array $queryParams = []){

    }

    public function authAsAdmin(string $email, string $password)
    {
        $ch = curl_init();

        $bodyParams['identity'] = $email;
        $bodyParams['password'] = $password;

        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/admins/auth-with-password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyParams);
        $output = curl_exec($ch);
        $json = json_decode($output, JSON_FORCE_OBJECT);
        self::$token = $json['token'];
        curl_close($ch);
    }
}

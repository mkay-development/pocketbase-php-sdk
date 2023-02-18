<?php

namespace Pb;

/**
 *
 */
class Collection
{
    /**
     * @var string
     */
    private string $collection;

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
    public function __construct(string $url, string $collection)
    {
        $this->url = $url;
        $this->collection = $collection;
    }

    /**
     * @param int $batch
     * @param array $queryParams
     * @return mixed
     */
    public function getFullList(int $batch = 200, array $queryParams = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/" . $this->collection . "/records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (self::$token != '') {
            $headers = array(
                'Content-Type:application/json',
                'Authorization: ' . self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, JSON_FORCE_OBJECT);
    }

    /**
     * @param string $filter
     * @param array $queryParams
     * @return void
     */
    public function getFirstListItem(string $filter, array $queryParams = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/" . $this->collection . "/records?perPage=&page=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (self::$token != '') {
            $headers = array(
                'Content-Type:application/json',
                'Authorization: ' . self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, JSON_FORCE_OBJECT);
    }

    /**
     * @param array $bodyParams
     * @param array $queryParams
     * @return void
     */
    public function create(array $bodyParams = [], array $queryParams = [])
    {
        $ch = curl_init();

        if (self::$token != '') {
            $headers = array(
                'Content-Type:application/json',
                'Authorization: ' . self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/" . $this->collection . "/records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyParams));
        $output = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @param string $recordId
     * @param array $bodyParams
     * @param array $queryParams
     * @return void
     */
    public function update(string $recordId, array $bodyParams = [], array $queryParams = [])
    {
        $ch = curl_init();

        if (self::$token != '') {
            $headers = array(
                'Content-Type:application/json',
                'Authorization: ' . self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/" . $this->collection . "/records/" . $recordId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyParams));
        $output = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @param string $recordId
     * @param array $queryParams
     * @return void
     */
    public function delete(string $recordId, array $queryParams = []):void
    {
        $ch = curl_init();

        if (self::$token != '') {
            $headers = array(
                'Content-Type:application/json',
                'Authorization: ' . self::$token
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_URL, $this->url . "/api/collections/" . $this->collection . "/records/" . $recordId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $output = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @param string $recordId
     * @param array $queryParams
     * @return void
     */
    public function getOne(string $recordId, array $queryParams = [])
    {
        // Todo: implibment logic
    }

    /**
     * @param string $email
     * @param string $password
     * @return void
     */
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

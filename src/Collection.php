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
     * @param int $start
     * @param int $end
     * @param array $queryParams
     * @return array
     */
    public function getList(int $start = 1, int $end = 50, array $queryParams = []): array
    {
        $getParams = !empty($queryParams) ? http_build_query($queryParams) : "";
        $response = $this->doRequest($this->url . "/api/collections/" . $this->collection . "/records?" . $getParams, 'GET');

        return json_decode($response, JSON_FORCE_OBJECT);
    }

    /**
     * @param string $email
     * @param string $password
     * @return void
     */
    public function authAsUser(string $email, string $password)
    {
        $result = $this->doRequest($this->url . "/api/collections/users/auth-with-password", 'POST', ['identity' => $email, 'password' => $password]);
        if (!empty($result['token'])) {
            self::$token = $result['token'];
        }
    }

    /**
     * @param int $batch
     * @param array $queryParams
     * @return array
     */
    public function getFullList(int $batch = 200, array $queryParams = []): array
    {
        $queryParams = [... $queryParams, ['perPage' => $batch]];
        $getParams = !empty($queryParams) ? http_build_query($queryParams) : "";
        $response = $this->doRequest($this->url . "/api/collections/" . $this->collection . "/records?" . $getParams, 'GET');

        return json_decode($response, JSON_FORCE_OBJECT);
    }

    /**
     * @param string $filter
     * @param array $queryParams
     * @return array
     */
    public function getFirstListItem(string $filter, array $queryParams = []): array
    {
        $queryParams['perPage'] = 1;
        $getParams = !empty($queryParams) ? http_build_query($queryParams) : "";
        $response = $this->doRequest($this->url . "/api/collections/" . $this->collection . "/records?" . $getParams, 'GET');
        return json_decode($response, JSON_FORCE_OBJECT)['items'][0];
    }

    /**
     * @param array $bodyParams
     * @param array $queryParams
     * @return void
     */
    public function create(array $bodyParams = [], array $queryParams = []): string
    {
        return $this->doRequest($this->url . "/api/collections/" . $this->collection . "/records", 'POST', json_encode($bodyParams));
    }

    /**
     * @param string $recordId
     * @param array $bodyParams
     * @param array $queryParams
     * @return void
     */
    public function update(string $recordId, array $bodyParams = [], array $queryParams = []): void
    {
        // Todo bodyParams equals json, currently workaround
        $this->doRequest($this->url . "/api/collections/" . $this->collection . "/records/" . $recordId, 'PATCH', json_encode($bodyParams));
    }

    /**
     * @param string $recordId
     * @param array $queryParams
     * @return void
     */
    public function delete(string $recordId, array $queryParams = []): void
    {
        $this->doRequest($this->url . "/api/collections/" . $this->collection . "/records/" . $recordId, 'DELETE');
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
     * @param string $recordId
     * @param array $queryParams
     * @return mixed
     */
    public function getOne(string $recordId, array $queryParams = []): array
    {
        $output = $this->doRequest($this->url . "/api/collections/" . $this->collection . "/records/" . $recordId, 'GET');
        return json_decode($output, JSON_FORCE_OBJECT);
    }

    /**
     * @param string $email
     * @param string $password
     * @return void
     */
    public function authAsAdmin(string $email, string $password): void
    {
        $bodyParams['identity'] = $email;
        $bodyParams['password'] = $password;
        $output = $this->doRequest($this->url . "/api/admins/auth-with-password", 'POST', $bodyParams);
        self::$token = json_decode($output, true)['token'];
    }
}

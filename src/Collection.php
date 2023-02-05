<?php

namespace Pb;

class Collection
{
    private $json;

    public function __construct($data)
    {
        $this->json = $data;
    }

    public function authWithPassword(){
        var_dump($this->json);
    }
}

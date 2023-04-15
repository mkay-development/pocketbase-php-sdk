<?php

namespace Pb;

class Client
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function collection(string $collection): Collection
    {
        return new Collection($this->url ,$collection);
    }

    public function settings(): Settings
    {
        return new Settings($this->url);
    }
}

<?php

namespace App\Core\Config\Provider;

class Json
{
    /**
     * @var string
     */
    protected $config;

    /**
     * Json constructor.
     */
    public function __construct()
    {
        $this->config = (__DIR__) . '\..\..\..\config.json';
    }

    /**
     * @return mixed
     */
    public function load()
    {
        return json_decode(file_get_contents($this->config), true);
    }
}
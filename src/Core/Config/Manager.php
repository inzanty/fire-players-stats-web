<?php

namespace App\Core\Config;

use App\Core\Config\Provider\Json;

class Manager
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->data = (new Json())->load();
    }

    /**
     * @param $key
     * @return false|mixed
     */
    public function get($key)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : false;
    }
}
<?php

namespace App\Core;

use App\Core\Config\Manager;
use Slim\Views\Twig;

class DependencyProvider
{
    /**
     * @var Manager
     */
    protected $config;

    /**
     * DependencyProvider constructor.
     * @param Manager $config
     */
    public function __construct(Manager $config)
    {
        $this->config = $config;
    }

    /**
     * @return Manager[]
     */
    public function register()
    {
        return [
            'config' => $this->config,

            'view' => function () {
                return Twig::create('templates', ['templates/cache']);
            }
        ];
    }
}
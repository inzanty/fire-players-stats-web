<?php

namespace App\Core;

use App\Core\Config\Manager;
use Slim\Views\Twig;
use PDO;

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

            'web_db' => function () {
                $config = $this->config->get('web_db');
                return new PDO(
                    sprintf(
                        'mysql:dbname=%s;host=%s;port=%s',
                        $config['database'],
                        $config['hostname'],
                        $config['port']
                    ),
                    $config['username'],
                    $config['password']
                );
            },

            'stats_db' => function () {
                $config = $this->config->get('stats_db');
                return new PDO(
                    sprintf(
                        'mysql:dbname=%s;host=%s;port=%s',
                        $config['database'],
                        $config['hostname'],
                        $config['port']
                    ),
                    $config['username'],
                    $config['password']
                );
            },

            'view' => function () {
                $twig = Twig::create('templates', ['templates/cache']);
                $twig->getEnvironment()->addGlobal('session', $_SESSION);
                return $twig;
            }
        ];
    }
}
<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

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
                $pdo = new PDO(
                    sprintf(
                        'mysql:dbname=%s;host=%s;port=%s',
                        $config['database'],
                        $config['host'],
                        $config['port']
                    ),
                    $config['username'],
                    $config['password']
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
            },

            'stats_db' => function () {
                $config = $this->config->get('stats_db');
                $pdo = new PDO(
                    sprintf(
                        'mysql:dbname=%s;host=%s;port=%s',
                        $config['database'],
                        $config['host'],
                        $config['port']
                    ),
                    $config['username'],
                    $config['password']
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
            },

            'view' => function () {
                $twig = Twig::create('templates', ['templates/cache']);
                $twig->getEnvironment()->addGlobal('session', $_SESSION);
                return $twig;
            }
        ];
    }
}
<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App;

use App\Core\Config\Manager;
use App\Core\DependencyProvider;
use App\Route\Register;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use DI\ContainerBuilder;
use DI\Container;
use PDO;

class Application
{
    /**
     * @var string
     */
    public static $version = '0.0.1';

    /**
     * @var int
     */
    public static $time = 0;

    /**
     * @var \Slim\App
     */
    public static $app;

    /**
     * @var Container
     */
    public static $container;

    /**
     * @var string[]
     */
    protected $logType = [
        'error',
        'exception',
        'warning'
    ];

    /**
     * @throws \Exception
     */
    public function boot()
    {
        // to avoid slim conflict
        session_cache_limiter(false);
        session_start();

        $config = new Manager();

        $dependencyProvider = (new DependencyProvider($config))->register();

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($dependencyProvider);
        $container = $containerBuilder->build();

        $app = AppFactory::createFromContainer($container);
        $this->setDefaultVariableValues($container, $app);
        $app->add(TwigMiddleware::createFromContainer($app));
        $app->group('', Register::class);
        $app->run();
    }

    /**
     * @param Container $container
     * @param App $app
     */
    public function setDefaultVariableValues(Container $container, App $app)
    {
        self::$app = $app;
        self::$container = $container;
        self::$time = time();
    }

    /**
     * @param $class
     * @return mixed
     * @throws \Exception
     */
    public static function repository($class)
    {
        if (class_exists($class))
        {
            return new $class();
        }

        throw new \Exception(sprintf("Repository class %s didn't exists", $class));
    }

    /**
     * @return PDO
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function getWebDb()
    {
        return self::$container->get('web_db');
    }

    /**
     * @return PDO
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function getStatsDb()
    {
        return self::$container->get('stats_db');
    }

    /**
     * @return App
     */
    public static function getInstance(): App
    {
        return self::$app;
    }

    public static function getConfig()
    {
        return self::$container->get('config');
    }
}
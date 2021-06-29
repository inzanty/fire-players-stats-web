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
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use DI\ContainerBuilder;

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
        $config = new Manager();

        $dependencyProvider = (new DependencyProvider($config))->register();

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($dependencyProvider);
        $container = $containerBuilder->build();

        $app = AppFactory::createFromContainer($container);
        $app->add(TwigMiddleware::createFromContainer($app));
        $app->group('', Register::class);
        $app->run();

        $this->setDefaultVariableValues($container);
    }

    /**
     * @param $container
     */
    public function setDefaultVariableValues($container)
    {
        self::$container = $container;
        self::$time = time();
    }

    /**
     * @throws \Exception
     */
    public static function repository($class)
    {
        $repository = sprintf("App\\Repository\\%s", $class);

        if (class_exists($repository))
        {
            return new $repository();
        }

        throw new \Exception(sprintf("Repository class %s didn't exists", $repository));
    }
}
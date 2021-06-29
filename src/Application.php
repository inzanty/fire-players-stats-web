<?php

namespace App;

use App\Core\Config\Manager;
use App\Core\DependencyProvider;
use App\Route\Register;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use DI\ContainerBuilder;

class Application
{
    /**
     * @var string
     */
    public static $version = '1.0.0';

    /**
     * @var int
     */
    public static $time = 0;

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

        $this->setDefaultVariableValues();
    }

    public function setDefaultVariableValues()
    {
        self::$time = time();
    }
}
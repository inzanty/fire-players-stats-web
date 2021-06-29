<?php

namespace App\Controller;

use DI\Container;
use Slim\Views\Twig;

abstract class AbstractController
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Twig
     */
    protected $view;

    /**
     * AbstractController constructor.
     * @param Container $container
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container->get('view');
    }
}
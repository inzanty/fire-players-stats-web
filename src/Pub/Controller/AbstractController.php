<?php

namespace App\Pub\Controller;

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

    /**
     * @param int $count
     * @param string $args
     * @param int $limit
     * @return array
     */
    public function paginate(int $count, int $args, int $limit = 15): array
    {
        $pages = ceil($count / $limit);
        $args = ($args > $pages) ? $pages : $args;

        $page = ($args > 0) ? $args : 1;
        $start = ($page - 1) * $limit;

        return [
            'needed' => $count > $limit,
            'page' => $page,
            'limit' => $limit,
            'start' => $start,
            'total' => $count,
            'pages' => $pages,
            'last' => $page - 1,
            'next' => $page + 1,
        ];
    }
}
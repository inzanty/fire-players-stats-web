<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Route;

use Slim\Routing\RouteCollectorProxy;

class Register
{
    public function __invoke(RouteCollectorProxy $group)
    {
        $group->get('/', 'App\Pub\Controller\Main:actionIndex');
        $group->get('/auth', 'App\Pub\Controller\Auth:actionLogin');
        $group->get('/auth/exit', 'App\Pub\Controller\Auth:actionExit');
        $group->get('/servers', 'App\Pub\Controller\Server:actionIndex');
        $group->get('/profile', 'App\Pub\Controller\Profile:actionIndex');
        $group->get('/stats', 'App\Pub\Controller\Stats:actionIndex');
        $group->get('/stats/load', 'App\Pub\Controller\Stats:actionLoad');
    }
}
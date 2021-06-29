<?php

namespace App\Route;

use Slim\Routing\RouteCollectorProxy;

class Register
{
    public function __invoke(RouteCollectorProxy $group)
    {
        $group->get('/', 'App\Controller\MainController:actionIndex');
    }
}
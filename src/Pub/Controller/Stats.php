<?php

namespace App\Pub\Controller;

use App\Application;
use App\Repository\Statistic;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Stats extends AbstractController
{
    public function actionIndex(Request $request, Response $response)
    {
        /** @var \App\Repository\Statistic $statisticRepo */
        $statisticRepo = Application::repository(Statistic::class);

        return $this->view->render($response, 'stats/index.html.twig');
    }
}
<?php

namespace App\Pub\Controller;

use App\Application;
use App\Repository\Statistic;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Stats extends AbstractController
{
    public function actionIndex(Request $request, Response $response)
    {
        /** @var \App\Repository\Statistic $statisticRepo */
        $statisticRepo = Application::repository(Statistic::class);
        dd($statisticRepo->getServerStatisticById(is_null($_GET['server']) ? 1 : $_GET['server']));
    }
}
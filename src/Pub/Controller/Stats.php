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

        $params = $request->getQueryParams();
        $server = $params['server'] ?? 1;
        // TODO: ensure that server exists or 404
        $paginationParams = $this->paginate(
            $statisticRepo->getCountById($server), $params['page'] ?? 1
        );

        return $this->view->render($response, 'stats/index.html.twig', [
            'pagination' => $paginationParams
        ]);
    }

    public function actionLoad(Request $request, Response $response)
    {
        /** @var \App\Repository\Statistic $statisticRepo */
        $statisticRepo = Application::repository(Statistic::class);

        $params = $request->getQueryParams();
        $server = $params['server'] ?? 1;
        $paginationParams = $this->paginate(
            $statisticRepo->getCountById($server), $params['page'] ?? 1
        );
        // TODO: secure or filter params because we pass it into query
        $sort = !$params['sortBy'] ? null :
            join(', ', array_map(function ($by, $desc) {
				return "`$by` " . ($desc ? 'DESC' : 'ASC');
			}, $params['sortBy'], $params['sortDesc']));

        $data = [
            'items' => $statisticRepo->getServerStatisticById($server, $paginationParams['start'], $paginationParams['limit'], $sort),
            'total' => $paginationParams['total']
        ];

        $payload = json_encode((object) $data);
        $response->getBody()->write($payload);
        return $response
                ->withHeader('Content-Type', 'application/json');
    }
}
<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Pub\Controller;

use App\Application;
use App\Repository\Server as ServerRepository;
use App\Util\Api\Steam;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Server extends AbstractController
{
    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     * @throws \Exception
     */
    public function actionIndex(Request $request, Response $response): \Psr\Http\Message\ResponseInterface
    {
        /** @var \App\Repository\Server $serverRepository */
        $serverRepository = Application::repository(ServerRepository::class);
        $paginationParams = $this->paginate(
            $serverRepository->getCount(), is_null($_GET['page']) ? 1 : $_GET['page']
        );

        return $this->view->render($response, 'server/index.html.twig', [
            'pagination' => $paginationParams,
            'servers' => $serverRepository->findAll($paginationParams['start'], $paginationParams['limit'])
        ]);
    }
}
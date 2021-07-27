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
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

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
        return $this->view->render($response, 'server/index.html.twig', [
            'servers' => $serverRepository->findAll()
        ]);
    }
}
<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Pub\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Main extends AbstractController
{
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function actionIndex(Request $request, Response $response, $args = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->view->render($response, 'main/index.html.twig');
    }
}
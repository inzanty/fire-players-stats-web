<?php

namespace App\Controller;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class MainController extends AbstractController
{
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function actionIndex(Request $request, Response $response, $args = []): \Psr\Http\Message\ResponseInterface
    {
        return $this->view->render($response, 'test.twig');
    }
}
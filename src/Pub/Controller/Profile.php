<?php

namespace App\Pub\Controller;

use App\Application;
use App\Repository\Player;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Profile extends AbstractController
{
    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     * @throws \Exception
     */
    public function actionIndex(Request $request, Response $response)
    {
        if (($_SESSION['nickname'] && $_SESSION['steam_id']) == null)
        {
            return $response->withHeader('Location', '/');
        }

        /** @var \App\Repository\Player $playerRepo */
        $playerRepo = Application::repository(Player::class);
        return $this->view->render($response, 'profile/index.html.twig', [
            'stats' => $playerRepo->getPlayerStats($_SESSION['steam_id'])
        ]);
    }
}
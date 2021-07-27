<?php

namespace App\Pub\Controller;

use App\Application;
use App\Repository\Player;
use App\Repository\Statistic;
use App\Repository\User;
use App\Util\Api\Steam;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Profile extends AbstractController
{
    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     * @throws \Exception
     */
    public function actionIndex(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        if (array_key_exists('steam_id', $params))
        {
            $steamInstance = new Steam();
            $steamId = $steamInstance->isValid($params['steam_id']);

            if ($steamId)
            {
                /** @var \App\Repository\Player $playerRepo */
                $playerRepo = Application::repository(Player::class);

                /** @var \App\Repository\User $userRepo */
                $userRepo = Application::repository(User::class);

                /** @var \App\Repository\Statistic $statsRepo */
                $statsRepo = Application::repository(Statistic::class);

                return $this->view->render($response, 'profile/index.html.twig', [
                    'profile_data' => $userRepo->getUser($params['steam_id'])[0],
                    'stats' => $playerRepo->getPlayerStats($params['steam_id'])[0],
                    'maps_stats' => $playerRepo->getMapsStats($params['steam_id']),
                    'weapons_stats' => $playerRepo->getWeaponsStats($params['steam_id']),
                    'servers_stats' => $statsRepo->fetchServersStatisticById($params['steam_id'])
                ]);
            }
        }

        return $response->withHeader('Location', '/');
    }
}
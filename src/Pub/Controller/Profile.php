<?php

namespace App\Pub\Controller;

use App\Application;
use App\Repository\Player;
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

                $st = new \SteamID(1153411562);
                return $this->view->render($response, 'profile/index.html.twig', [
                    'avatar' => $userRepo->getUserAvatar($params['steam_id']),
                    'stats' => $playerRepo->getPlayerStats($st->ConvertToUInt64())[0],
                    //'stats' => $userRepo->getUserAvatar($params['steam_id']),
                    'maps_stats' => $playerRepo->getMapsStats(1153411562),
                    'weapons_stats' => $playerRepo->getWeaponsStats(1153411562)
                ]);
            }
        }

        return $response->withHeader('Location', '/');
    }
}
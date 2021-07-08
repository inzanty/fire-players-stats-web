<?php

namespace App\Pub\Controller;

use App\Application;
use App\Repository\User;
use App\Util\Api\Steam;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use LightOpenID;

class Auth extends AbstractController
{
    const STEAM_URL = 'https://steamcommunity.com/openid';

    /**
     * @throws \DI\NotFoundException
     * @throws \DI\DependencyException
     * @throws \ErrorException
     */
    public function actionLogin(Request $request, Response $response)
    {
        $openId = new LightOpenID(sprintf("%s://%s", $_SERVER['REQUEST_SCHEME'], $_SERVER['SERVER_NAME']));
        if (!$openId->mode)
        {
            $openId->identity = self::STEAM_URL;
            header('Location: ' . $openId->authUrl());
        }
        else if ($openId->mode == 'id_res' && $openId->validate())
        {
            $id = $openId->identity;
            $ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
            preg_match($ptn, $id, $matches);

            $steamApiInstance = new Steam();

            /** @var User $playerRepository */
            $playerRepository = Application::repository('User');
            $player = $playerRepository->getUser($matches[1]);
            if (!$player)
            {
                $player = $playerRepository->createUser([
                    'nickname' => $steamApiInstance->getNicknameById($matches[1]),
                    'steam_id' => $matches[1]
                ]);
            }

            $_SESSION['nickname'] = $player[0]['nickname'];
            $_SESSION['steam_id'] = $player[0]['steam_id'];

            return $response->withHeader('Location', '/');
        }

        return '';
    }

    public function actionExit(Request $request, Response $response)
    {
        if (!is_null(!empty($_SESSION['nickname']) && !is_null(!empty($_SESSION['steam_id']))))
        {
            session_destroy();
            return $response->withHeader('Location', '/');
        }

        return '';
    }
}
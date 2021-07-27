<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Pub\Controller;

use App\Application;
use App\Repository\User;
use App\Util\Api\Steam;
use ErrorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LightOpenID;

class Auth extends AbstractController
{
    const STEAM_URL = 'https://steamcommunity.com/openid';

    /**
     * @throws ErrorException
     */
    public function actionLogin(Request $request, Response $response)
    {
        $openId = new LightOpenID(
            sprintf("%s://%s", $request->getUri()->getScheme(), $request->getUri()->getHost())
        );

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

            $steamInstance = new Steam();

            /** @var User $playerRepository */
            $playerRepository = Application::repository(User::class);
            $player = $playerRepository->getUser($matches[1]);
            if (!$player)
            {
                $profileData = $steamInstance->getProfileDataById($matches[1]);
                $player = $playerRepository->createUser([
                    'nickname' => $profileData['nickname'],
                    'steam_id' => $matches[1],
                    'avatar_icon' => $profileData['avatar_icon'],
                    'avatar_full' => $profileData['avatar_full']
                ]);
            }

            $_SESSION['nickname'] = $player[0]['nickname'];
            $_SESSION['steam_id'] = $player[0]['steam_id'];
            $_SESSION['avatar_icon'] = $player[0]['avatar_icon'];

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
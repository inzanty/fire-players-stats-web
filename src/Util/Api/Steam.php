<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Util\Api;

class Steam
{
    /**
     * @param $id
     * @return false|string
     */
    public function isValid($id)
    {
        try
        {
            $steamId = new \SteamID($id);
            $steamId->IsValid();

            return $steamId->ConvertToUInt64();
        }
        catch (\InvalidArgumentException $e)
        {
            return false;
        }
    }

    /**
     * @param $id
     * @return array|false
     */
    public function getProfileDataById($id)
    {
        $xml = simplexml_load_file(sprintf("https://steamcommunity.com/profiles/%s/?xml=1", $id));
        return !empty($xml) ? [
            'nickname' => $xml->steamID,
            'avatar_icon' => $xml->avatarMedium,
            'avatar_full' => $xml->avatarFull
        ] : false;
    }
}
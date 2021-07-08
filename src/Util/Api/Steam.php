<?php

namespace App\Util\Api;

class Steam
{
    /**
     * @param $id
     * @return false|\SimpleXMLElement
     */
    public function getNicknameById($id)
    {
        $xml = simplexml_load_file(sprintf("https://steamcommunity.com/profiles/%s/?xml=1", $id));
        return !empty($xml) ? $xml->steamID : false;
    }
}
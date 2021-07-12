<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Repository;

class Player extends AbstractRepository
{
    /**
     * @param $id
     * @return array
     */
    public function getPlayerStats($id): array
    {
        $instance = new \SteamID($id);
        $accountId = $instance->GetAccountID();

        $stmt = $this->statsDb->prepare("
            SELECT * FROM fps_servers_stats WHERE account_id = ?
        ");
        $stmt->execute([$accountId]);
        return $stmt->fetchAll();
    }
}
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
            SELECT SUM(fps_maps.playtime) as playtime,
                   SUM(fps_servers_stats.round_win) AS round_win,
                   SUM(fps_servers_stats.round_lose) AS round_lose,
                   SUM(fps_servers_stats.kills) AS kills, 
                   SUM(fps_servers_stats.deaths) AS deaths, 
                   SUM(fps_servers_stats.assists) AS assists,
                   SUM(fps_weapons_stats.hits_head + fps_weapons_stats.hits_chest + fps_weapons_stats.hits_left_arm + fps_weapons_stats.hits_right_arm + fps_weapons_stats.hits_left_leg + fps_weapons_stats.hits_right_leg) AS hits,
                   SUM(fps_weapons_stats.hits_head) AS hits_head,
                   SUM(fps_weapons_stats.hits_chest) AS hits_chest,
                   SUM(fps_weapons_stats.hits_left_arm) AS hits_left_arm,
                   SUM(fps_weapons_stats.hits_right_arm) AS hits_right_arm,
                   SUM(fps_weapons_stats.hits_left_leg) AS hits_left_leg,
                   SUM(fps_weapons_stats.hits_right_leg) AS hits_right_leg,
                   SUM(fps_unusualkills.op) AS unusualkills_op,
                   SUM(fps_unusualkills.penetrated) AS unusualkills_penetrated,
                   SUM(fps_unusualkills.no_scope) AS unusualkills_noscope,
                   SUM(fps_unusualkills.run) AS unusualkills_run,
                   SUM(fps_unusualkills.jump) AS unusualkills_jump,
                   SUM(fps_unusualkills.flash) AS unusualkills_flash,
                   SUM(fps_unusualkills.smoke) AS unusualkills_smoke,
                   SUM(fps_unusualkills.whirl) AS unusualkills_whirl,
                   SUM(fps_unusualkills.last_clip) AS unusualkills_lastclip
            FROM fps_servers_stats 
            LEFT JOIN fps_weapons_stats
                ON fps_servers_stats.account_id = fps_weapons_stats.account_id
            LEFT JOIN fps_unusualkills
                ON fps_servers_stats.account_id = fps_unusualkills.account_id
            LEFT JOIN fps_maps
                ON fps_servers_stats.account_id = fps_maps.account_id
            WHERE fps_servers_stats.account_id = ?
        ");

        $stmt->execute([$accountId]);
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getMapsStats($id): array
    {
        $instance = new \SteamID($id);
        $accountId = $instance->GetAccountID();

        $stmt = $this->statsDb->prepare("
            SELECT rounds_t, rounds_ct, name_map, countplays
            FROM fps_maps
            WHERE account_id = ?
            ORDER BY countplays DESC
        ");

        $stmt->execute([$accountId]);
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function getWeaponsStats($id): array
    {
        $instance = new \SteamID($id);
        $accountId = $instance->GetAccountID();

        $stmt = $this->statsDb->prepare("
            SELECT weapon, kills, shoots
            FROM fps_weapons_stats
            WHERE account_id = ?
            ORDER BY kills DESC 
        ");

        $stmt->execute([$accountId]);
        return $stmt->fetchAll();
    }
}
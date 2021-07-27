<?php

namespace App\Repository;

class Statistic extends AbstractRepository
{
    /**
     * @param $id
     * @return array
     */
    public function getServerStatisticById($id): array
    {
        $stmt = $this->statsDb->prepare("SELECT * FROM fps_servers_stats WHERE server_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchServersStatisticById($id): array
    {
        $stmt = $this->statsDb->prepare("
            SELECT fps_servers_stats.points,
                   fps_servers_stats.kills,
                   fps_servers_stats.deaths,
                   fps_servers_stats.assists,
                   fps_servers_stats.round_win,
                   fps_servers_stats.round_lose,
                   fps_servers_stats.playtime,
                   fps_servers.server_name
            FROM fps_servers_stats
            LEFT JOIN fps_servers
                ON fps_servers_stats.server_id = fps_servers.id
            WHERE account_id = ? 
            ORDER BY points
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return int
     */
    public function getCountById($id): int
    {
        $stmt = $this->statsDb->query("SELECT * FROM fps_servers_stats WHERE server_id = ?");
        $stmt->execute();
        return $stmt->rowCount();
    }
}
<?php

namespace App\Repository;

class Statistic extends AbstractRepository
{ 
    /**
     * getServerStatisticById
     *
     * @param  mixed $id
     * @param  mixed $skip
     * @param  mixed $limit
     * @return array
     */
    public function getServerStatisticById($id, $skip, $limit, ?string $sort=null): array
    {
        $sort = $sort ?? '`id`';
        $stmt = $this->statsDb->prepare("SELECT 
            `nickname`, 
            `points`, 
            `rank`, 
            `kills`, 
            `deaths`, 
            `assists`, 
            `round_max_kills`, 
            `round_win`, 
            `round_lose` 
            FROM fps_servers_stats 
            JOIN fps_players
            USING (account_id)
            WHERE server_id = ? 
            ORDER BY $sort 
            LIMIT ?, ?");
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->bindValue(2, $skip, \PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, \PDO::PARAM_INT);
        $stmt->execute();
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
        $stmt = $this->statsDb->prepare("SELECT COUNT(*) FROM fps_servers_stats WHERE server_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
}
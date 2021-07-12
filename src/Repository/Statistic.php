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
     * @return int
     */
    public function getCountById($id): int
    {
        $stmt = $this->statsDb->query("SELECT * FROM fps_servers_stats WHERE server_id = ?");
        $stmt->execute();
        return $stmt->rowCount();
    }
}
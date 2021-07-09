<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Repository;

use PDO;

class Server extends AbstractRepository
{
    /**
     * @param $skip
     * @param $limit
     * @return array
     */
    public function findAll($skip, $limit): array
    {
        $stmt = $this->statsDb->prepare("SELECT * FROM fps_servers LIMIT :skip, :limit");
        $stmt->bindParam(':skip', $skip, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->statsDb->query("SELECT * FROM fps_servers")->rowCount();
    }
}
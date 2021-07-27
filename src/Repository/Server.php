<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Repository;

class Server extends AbstractRepository
{
    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->statsDb->query("SELECT * FROM fps_servers")->fetchAll();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->statsDb->query("SELECT * FROM fps_servers")->rowCount();
    }
}
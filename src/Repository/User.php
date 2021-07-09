<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 */

namespace App\Repository;

class User extends AbstractRepository
{
    /**
     * Get user by steam id
     * @param $id
     * @return array
     */
    public function getUser($id): array
    {
        $stmt = $this->webDb->prepare("
            SELECT * FROM fps_web_players
            WHERE steam_id = :steam_id
        ");
        $stmt->bindParam(":steam_id", $id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Create user
     * @param array $user
     * @return array
     */
    public function createUser(array $user): array
    {
        $stmt = $this->webDb->prepare("
            INSERT INTO fps_web_players (nickname, steam_id)
            VALUES (:nickname, :steam_id)
        ");
        $stmt->bindParam(":nickname", $user['nickname']);
        $stmt->bindParam(":steam_id", $user['steam_id']);
        $stmt->execute();

        return $this->getUser($user['steam_id']);
    }
}
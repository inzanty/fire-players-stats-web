<?php

/*
 * FPS Web Interface
 * Year: 2021
 * Author: inzanty (inzanty@gmail.com)
 * In the repository, you can bring out the methods you need to get information from the database so as not to violate the DRY standard.
 * В репозитории вы можете вынести вам нужные методы для получение информации с базы данных что-бы не нарушать DRY стандарт.
 */

namespace App\Repository;

use App\Application;

abstract class AbstractRepository
{
    /**
     * @var mixed
     */
    protected $webDb;

    /**
     * @var mixed
     */
    protected $statsDb;

    public function __construct()
    {
        $this->webDb = Application::$container->get('web_db');
        $this->statsDb = Application::$container->get('stats_db');
    }
}
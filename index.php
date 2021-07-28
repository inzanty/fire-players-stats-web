<?php

$phpVersion = phpversion();
if (version_compare($phpVersion, '7.3.0', '<'))
{
    die("Требуеться PHP 7.3.0 или новее. Ваша версия PHP ($phpVersion) не подходит под наше требования. Обновите PHP или обратитесь к системному администратору за помощью.");
}

require 'vendor/autoload.php';

$app = new \App\Application();
$app->boot();
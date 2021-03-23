<?php

use core\base\exceptions\RouteException;
use core\base\controllers\RouteController;

// Определяет прохождение запроса через индекс

define('VG_ACCESS', true);
//отсылаем хедеры для браузера, синхронизируя с htaccess
header('Content-Type: text/html;charset=utf-8');

session_start();

// фаел для базовых настроек, для быстрой развертки сайта
require_once 'config.php';
//глубокие настройки всего проекта
require_once 'core/base/settings/internal_settings.php';

try {
    RouteController::getInstance()->route();
} catch (RouteException $e) {
    exit($e->getMessage());

}
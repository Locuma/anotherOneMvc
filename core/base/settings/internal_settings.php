<?php
use core\base\exceptions\RouteException;

defined('VG_ACCESS') or die('Access denied from keril');
// шаблоны, для отрисовки сайта
const TEMPLATE = 'templates/default/';
const ADMIN_TEMPLATE = 'core/admin/views/';
// константы безопасности
const COOKIE_VERSION = '1.0.0';
const CRYPT_KEY = '';
const COOKIE_TIME = 60; //время до инактива
const BLOCK_TIME = 3; //попыток вовода пароля
//для отображения пагинации
const QTY=8;
const QTY_LINKS=3;

const ADMIN_CSS_JS = [
    'styles' => [],
    'scripts'=> []
];
const USER_CSS_JS = [
    'styles' => [],
    'scripts'=> []
];
/**
 * @param string $className
 * @throws RouteException
 */
function autoloadMainClasses(string $className) {
    $className = str_replace('\\','/', $className);

    if(!@include_once $className . '.php'){
        throw new RouteException('Неверное имя файла для подключения - ' . $className);
    }
}

spl_autoload_register();
<?php


namespace core\base\controllers;
use core\base\settings\Settings;
use core\base\settings\ShopSettings;
use Exception;

class RouteController
{
    static private $_instance;

    protected $routes;

    protected $controller;
    protected $parameters;
    protected $outputMethod;
    protected $inputMethod;

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    private function __construct()
    {
        $addrStr = $_SERVER['REQUEST_URI'];

        if ($this->isUriEndsWithSlash() && $this->isUriOnlySlash()){
            $this->redirect(rtrim($addrStr, '/'), 301);
        }

        if ($this->getRootPath() === PATH){
            $this->routes = Settings::get('routes');

            if(!$this->routes) {
                throw new \Exception('Сайт на тех. обслуживании');
            }

            /**
             * Стоит ли значение параметра сразу после первого /
             * refactor
             */
            if (strpos($addrStr, $this->routes['admin']['alias']) === strlen(PATH)){
                // админка
                $url = explode('/', substr($addrStr, strlen(PATH)+1));
                if ($url[0] && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . $this->routes['plugins']['path'] . $url[0])){
                    // попали в плагин
                    $plugin = array_shift($url);
                    $pluginSettings = $this->routes['settings']['path'] . ucfirst($plugin) . 'Settings';
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . PATH . $pluginSettings . '.php')) {
                        $pluginSettingsClass = str_replace('/', '\\', $pluginSettings);
                        $this->routes = $pluginSettingsClass::get('routes');
                    }

                    $dir = $this->routes['plugins']['dir'] ? '/' . $this->routes['plugins']['dir'] : '/';
                    $dir = str_replace('//', '/', $dir);
                    $this->controller = $this->routes['plugins']['path'] . $plugin . $dir;
                    $hrUrl = $this->routes['plugins']['hrUrl'];

                    $route = 'plugins';

                } else {
                    $this->controller= $this->routes['admin']['path'];

                    $hrUrl = $this->routes['admin']['hrUrl'];

                    $route = 'admin';
                }
            } else {
                //user view
                $url = explode('/', substr($addrStr, strlen(PATH)));
                $hrUrl = $this->routes['user']['hrUrl'];
                $this->controller = $this->routes['user']['path'];

                $route = 'user';
            }

            $this->createRoute($route, $url);

            if ($url[1]){
                $count = count($url);
                $key = '';

                if(!$hrUrl){
                    $i = 1;
                } else {
                    $this->parameters['alias'] = $url[1];
                    $i = 2;
                }

                for (;$i < $count; $i++) {
                    if (!$key) {
                        $key = $url[$i];
                        $this->parameters[$key] = '';
                    } else {
                        $this->parameters[$key] = $url[$i];
                        $key = '';
                    }
                }
            }

            exit;

        } else {
            try{
                throw new Exception('Кривая директория ссайта');
            } catch (Exception $exception){
                $exception->getMessage();
            }
        }



    }

    private function createRoute($var, array $arr) : void
    {
        $route = [];

        if (!empty($arr[0])){
            if ($this->routes[$var]['routes'][$arr[0]]){
                $route = explode('/',$this->routes[$var]['routes'][$arr[0]]);

                $this->controller .= ucfirst($route[0] . 'Controller');
            } else {
                $this->controller .= ucfirst($arr[0] . 'Controller');
            }
        } else {
            $this->controller .= $this->routes['default']['controller'];
        }
        $this->inputMethod = $route[1] ? $route[1] : $this->routes['default']['inputMethod'];
        $this->outputMethod = $route[1] ? $route[1] : $this->routes['default']['outputMethod'];
    }

    private function getRootPath():string
    {
        return substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));
    }

    private function isUriEndsWithSlash():bool
    {
        return strrpos($_SERVER['REQUEST_URI'], '/') === strlen($_SERVER['REQUEST_URI'])-1;
    }

    private function isUriOnlySlash():bool
    {
        return strrpos($_SERVER['REQUEST_URI'], '/') !== 0;
    }

    static public function getInstance(){
        if (self::$_instance instanceof self){
            return self::$_instance;
        }
        return self::$_instance = new self();
    }

}
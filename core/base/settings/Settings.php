<?php


namespace core\base\settings;


class Settings
{
    static private $_instance;

    private $routes =[
        'admin' => [
            'name' => 'admin',
            'path' => 'core/admin/controller/',
            'hrUrl' => false
        ],
        'settings' => [
            'path' => 'core/vase/settings/'
        ],
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false
        ],
        'user' => [
            'path' => 'core/user/controller/',
            'hrUrl' => true,
            'routes' => [

            ]
        ],
        'default' => [
            'controller' => 'indexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData'
        ]
    ];

    private $templateArr = [
        'text' => ['name', 'phone', 'address'],
        'textarea' => ['content', 'keywords']
    ];

    private function __construct()
    {
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    static public function get(string $property)
    {
        return self::instance()->$property;
    }

    static public function instance()
    {
        if (self::$_instance instanceof self){
            return self::$_instance;
        }
            return self::$_instance = new self();
    }

    public function clueProperties($className)
    {
        $baseProperties = [];
        foreach ($this as $name => $item) {
            $property = $className::get($name);

            if (is_array($property) && is_array($item)){
                $baseProperties[$name] = $this->arrayMergeRecursive($this->$name, $property);
            }
        }

        exit();
    }

    public function arrayMergeRecursive()
    {
        //забираем из памяти параметры массивов
        $arrays = func_get_args();

//        var_dump($arrays);
        $base = array_shift($arrays);

        foreach ($arrays as $array){
            foreach ($array as $key => $value){
                if (is_array($value) && is_array($base[$key])){
                    $base[$key] = $this->arrayMergeRecursive($base[$key], $value);
                } else {
                    if (is_int($key)){
                        if (!in_array($value, $base)){
                            array_push($base, $value);
                            continue;
                        }
                        $base[$key] = $value;
                    }
                }
            }
        }
        return $base;
    }

}
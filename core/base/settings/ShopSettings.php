<?php


namespace core\base\settings;


class ShopSettings
{
    static private $_instance;
    private $baseSettings;

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    private function __construct()
    {
    }

    private $templateArr = [
        'text' => ['price','short'],
        'textarea' => ['goods_content']
    ];

    static public function get(string $property)
    {
        return self::instance()->$property;
    }


    static public function instance(){
        if (self::$_instance instanceof self){
            return self::$_instance;
        }
        self::$_instance = new self();
        var_dump(self::$_instance);
        self::$_instance->baseSettings = Settings::instance();
        $baseProperties = self::$_instance->baseSettings->clueProperties(get_class());
        return self::$_instance;
    }
}



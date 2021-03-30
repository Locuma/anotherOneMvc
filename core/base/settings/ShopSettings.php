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
    private $routes =[
        'admin' => [
            'name' => 'loh'
            ]
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
//        var_dump(self::$_instance );
//        var_dump("<br>");
//        var_dump("<br>");
//        foreach (self::$_instance as $name => $item){
//            var_dump('name: ' . $name . '<br>')  ;
//            var_dump('item: ' )  ;
//            var_dump($item)  ;
//            var_dump( '<br>')  ;
//        }
        self::$_instance->baseSettings = Settings::instance();
        $baseProperties = self::$_instance->baseSettings->clueProperties(get_class());
        return self::$_instance;
    }
}



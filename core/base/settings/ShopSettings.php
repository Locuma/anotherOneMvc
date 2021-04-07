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
        'text' => ['price', 'short'],
        'textarea' => ['goods_content']
    ];
    private $routes = [
        'admin' => [
        ],
    ];

    static public function get(string $property)
    {
        return self::instance()->$property;
    }

    /**
     * @mixin Settings
     * @return ShopSettings
     */
    static public function instance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        }
        self::$_instance = new self();
        self::$_instance->baseSettings = Settings::instance();
        $baseProperties = self::$_instance->baseSettings->clueProperties(get_class());
        self::$_instance->setProperties($baseProperties);
        return self::$_instance;
    }

    protected function setProperties($properties)
    {
        if ($properties){
            foreach ($properties as $name => $property) {
                $this->$name = $property;
            }
        }
    }
}



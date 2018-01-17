<?php

/**
 * 读取配置
 *
 * @author Hu Feng
 */
class Config
{

    //声明私有构造方法为了防止外部代码使用new来创建对象。
    public static $instance;

    //声明私有构造方法为了防止外部代码使用new来创建对象。
    private function __construct()
    {

    }

    //声明一个instance()静态方法，用于检测是否有实例对象
    public static function instance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

    /**
     * @param string $path
     * @param string $type
     * @return array|null|string
     */
    public function get($path = null, $type = 'php')
    {
        switch ($type) {
            case 'ini':
                return $this->getIni($path);
            case 'php':
            default:
                return $this->getPhp($path);
        }
    }

    private function getIni($path = null)
    {
        $config = null;
        if (file_exists(INI_CONFIG_PATH)) {
            $config = new Phalcon\Config\Adapter\Ini(INI_CONFIG_PATH);
            if ($path) {
                $config = $config->path($path);
            }
            if (is_object($config)) {
                $config = $config->toArray();
            }
        }
        return $config;
    }

    private function getPhp($path = '')
    {
        $config = null;
        if (file_exists(PHP_CONFIG_PATH)) {
            $config = new Phalcon\Config\Adapter\Php(PHP_CONFIG_PATH);
            if ($path) {
                $config = $config->path($path);
            }
            if (is_object($config)) {
                $config = $config->toArray();
            }
        }
        return $config;
    }
}

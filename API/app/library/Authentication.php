<?php

/**
 * 身份认证
 *
 * @author Hu Feng
 */
class authentication
{

    public static $instance;

    private function __construct()
    {
    }

    public static function instance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }


    /**
     * 生成TOKEN
     * @param string $delimiter
     * @return string
     */
    public function generateToken($delimiter = '')
    {
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8) . $delimiter;
        $uuid .= substr($str, 8, 4) . $delimiter;
        $uuid .= substr($str, 12, 4) . $delimiter;
        $uuid .= substr($str, 16, 4) . $delimiter;
        $uuid .= substr($str, 20, 12);
        return $uuid;
    }


}

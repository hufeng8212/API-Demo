<?php

/**
 * 签名认证
 *
 * @author Hu Feng
 */
class Sign
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
     * 生成签名
     * @param $params
     * @return string
     */
    public function generate($params)
    {
        $params = array_filter($params);
        ksort($params);
        $params['key'] = Config::instance()->get('sign.secret_key');
        return strtoupper(MD5(http_build_query($params)));
    }

    /**
     * 验证签名
     * @param $sign
     * @param $params
     * @return bool
     */
    public function verify($sign, $params){
        return $sign == $this->generate($params);
    }


}

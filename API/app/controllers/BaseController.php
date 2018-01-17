<?php

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{

    public $currentPageName = '';

    // 控制器初始化方法
    public function initialize()
    {

        $this->currentPageName = $this->dispatcher->getControllerName() . '/' . $this->dispatcher->getActionName();

        // 拦截OPTIONS请求
        $this->interceptOptions();
        // 签名验证
        $this->signVerify();
        // 身份认证
        $this->authentication();

    }

    /**
     * 拦截OPTIONS请求
     */
    private function interceptOptions()
    {
        $method = $this->request->getMethod();
        if ($method == 'OPTIONS') {
            Output::instance()->success();
        }
    }


    /**
     * 签名验证
     */
    private function signVerify()
    {
        //未开启签名验证，跳过
        if (!Config::instance()->get('sign.enable')) {
            return true;
        }

        // 过滤无需验证页面
        if (in_array($this->currentPageName, Config::instance()->get('sign.exclude'))) {
            return true;
        }

        // 过滤非POST,或无POST参数请求
        $params = $this->request->getPost();
        if (!$this->request->isPost() || count($params) == 0) {
            return true;
        }

        // 验证是否提交签名
        $sign = $this->request->getHeader('sign');
        if (!$sign) {
            Output::instance()->fail('缺少签名');
        }

        // 验证签名是否有效
        if (!Sign::instance()->verify($sign, $params)) {
            Output::instance()->fail('无效签名');
        }

    }


    /**
     * 身份验证
     */
    public function authentication()
    {
        if (!Config::instance()->get('authentication.enable')) {
            return true;
        }
        if (in_array($this->currentPageName, Config::instance()->get('authentication.exclude'))) {
            return true;
        }
        $token = $this->request->getHeader('token');
        if (!$token) {
            Output::instance()->fail('缺少TOKEN');
        }
    }


}
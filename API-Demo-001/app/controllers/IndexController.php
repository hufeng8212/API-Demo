<?php

class IndexController extends BaseController
{
    public function indexAction()
    {
        Output::instance()->success('Hello World.');
    }

    public function messageAction()
    {
        Output::instance()->success('测试消息接口');
    }

    public function itemAction()
    {
        $item = ['id' => 1, 'name' => 'item1'];
        Output::instance()->success((object)$item);
    }

    public function listAction()
    {
        $items = [
            ['id' => 1, 'name' => 'item1'],
            ['id' => 2, 'name' => 'item2'],
            ['id' => 3, 'name' => 'item3'],
        ];

        $list = [
            'page' => 1,
            'count' => 100,
            'items' => $items,
        ];
        Output::instance()->success($list);
    }

    public function errorAction()
    {
        Output::instance()->fail('错误来啦', 300);
    }

    public function exceptionAction()
    {
        throw new Exception('异常消息');
    }
}
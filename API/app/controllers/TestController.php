<?php


class TestController extends BaseController
{
    public function indexAction()
    {
        Output::instance()->success('test');
    }
}
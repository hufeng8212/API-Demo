<?php

/**
 * 输出数据
 *
 * @author Hu Feng
 */
class Output
{

    public static $instance;
    private $response = null;

    private function __construct()
    {
        $this->response = new Phalcon\Http\Response();
//        $this->response->setHeader('version', VERSION);
    }

    public static function instance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

    /**
     * 重写JSON格式的字符串进行编码
     * @param $data
     * @param null $options
     * @return string
     */
    private function JsonEncode($data, $options = null)
    {
        return json_encode($this->DataAsString($data), $options);
    }

    /**
     * 数据值强转字符串
     * @param $data
     * @return mixed
     */
    private function DataAsString($data)
    {
        $data = is_object($data) ? (array)$data : $data;
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $data[$key] = $this->DataAsString($value);
                } else {
                    $data[$key] = (string)$value;
                }
            }
        }
        return $data;
    }

    /**
     * 输出接口数据
     * @param $body
     */
    public function json($body)
    {
        $this->response->sendHeaders();
        $options = NULL;
        // 调试开启
        if (Config::instance()->get('debug')) {
            $options = $options | JSON_UNESCAPED_UNICODE; // 中文不转码
        }
        die(self::JsonEncode($body, $options));
    }

    /**
     * 输出成功数据
     * @param $data
     */
    public function success($data = '')
    {
        $body = [
            'status' => '1',
        ];
        if (is_object($data)) {
            $body['item'] = $data;
        } elseif (is_array($data)) {
            $body['list'] = $data;
        } else {
            $body['value'] = $data;
        }
        $this->json($body);
    }

    /**
     * 输出失败数据
     * @param $message
     * @param int $code
     * @param string $track
     */
    public function fail($message, $code = 300, $track = null)
    {
        $body = [
            'status' => '0',
            'code' => $code,
            'message' => $message,
        ];
        if ($track) {
            $body['track'] = $track;
        }
        $this->json($body);
    }
}

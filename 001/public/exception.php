<?php

/**
 * 记录错误日志
 * @param $error_code 错误代码
 * @param $error_message 错误消息
 * @param $error_file 错误文件
 * @param $error_line 错误行
 */
function log_write($error_code, $error_message, $error_file, $error_line)
{
    $log = date('Y-m-d H:i:s');
    $log .= ' | ' . '[' . $error_code . '] ';
    $log .= $error_message . PHP_EOL;
    $log .= $error_file . ', line : ' . $error_line . PHP_EOL;
    $filename = LOG_PATH . '/' . date('Ymd') . '.log';
    file_put_contents($filename, $log . PHP_EOL, FILE_APPEND);
}

/**
 * 输出错误信息
 * @param $message 错误消息
 * @param $code 错误代码
 * @param string $track 错误位置
 */
function error_output($message, $code, $track = null)
{
    $error = [
        'status' => '0',
        'code' => $code . '',
        'message' => $message,
    ];

    $options = null;
    $config = new Phalcon\Config\Adapter\Php(PHP_CONFIG_PATH);
    // 调试开启
    if ($config->debug && $track) {
        $error['track'] = $track; // 输出出错位置信息
        $options = $options | JSON_UNESCAPED_UNICODE; // 中文不转码
    }
    die(json_encode($error, $options));
}

set_error_handler(function ($error_code, $error_message, $error_file, $error_line) {
    log_write($error_code, $error_message, $error_file, $error_line);
    error_output($error_message, 500, $error_file . ', line : ' . $error_line);
});

set_exception_handler(function (Exception $e) {
    log_write($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    error_output($e->getMessage(), 300, $e->getFile() . ', line : ' . $e->getLine());
});
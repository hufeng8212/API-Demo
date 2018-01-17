<?php
return [
    'debug' => 1, // 是否开启调试
    'sign' => [
        'enable' => 1, // 开启验签
        'secret_key' => '',
        // 验签排除页面
        'exclude' => [
            'test/index',
        ]
    ],

    'authentication' => [
        'enable' => 0,  // 开启身份认证
        // 身份认证排除页面
        'exclude' => [
            'test/index',
        ]
    ]
];
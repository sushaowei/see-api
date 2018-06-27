<?php

return[
    'id'=>'see_console',
    'basePath' => dirname(__DIR__),
    "components"=>[
        //日志设置
        "log" => [
            "class" => "\see\base\LoggerTrace",
        ],
    ],
];

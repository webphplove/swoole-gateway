<?php
return [
    "server" => [
        "default" => 'https://wiki.swoole.com',
        "group1" => [
            "https://wiki.swoole.com"
        ],
        "group2" => [
            "https://wiki.swoole.com",
            "https://wiki.swoole.com"
        ]
    ],
    "route" => [
        [
            "source" => "/greeting",
            "target" => "group1"
        ],
        [
            "source" => "/hello",
            "target" => "group2"
        ]
    ]
];

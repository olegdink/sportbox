<?php

// Config (можно оформить как класс, который будет имплементировать систему конанических конфигов,
// с настройками prod/dev среды и debug режима, логеры и т.д.

$config = [
    'source' => "http://news.sportbox.ru/paralympic/stats/reiting_197",
    'cache' => [
        'type'       => 'Memcached', // class
        'host'       => 'localhost', // host
        'port'       => '11211',     // port
        'key'        => 'sport',     // key for store
        'expiration' => 20,          // seconds
    ],
];

// Memcached (можно вынести в отдельный класс, через синглтон с настройками и коннектором)

$cacheType = $config['cache']['type'];
$cacheType = $config['cache']['type'];

$m = new $cacheType();
$m->addServer($config['cache']['host'], $config['cache']['port']);

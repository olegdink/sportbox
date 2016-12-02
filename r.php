<?php

// можно обернуть в автолоадинг, но делать это ради одного класса не стоит

require('config.php');
require('Parser.php');

if (!empty($_GET['debug'])) { $debug = true; } else { $debug = false; };

$parser = new Sportbox\Parser\Parser($config['source']);

// check cache

$json = '';
$resJson = $m->get($config['cache']['key']);
$cached = '';

if ($resJson === false) {
    $json = json_encode($parser->getInfo());
    $m->set($config['cache']['key'], $json, time() + 20);
    $cached = 'realtime';
} else {
    $json = $resJson;
    $cached = 'cached';
};

echo $json;

// debug to check directly from browser

echo ($debug) ? "<br/>$cached<br/>" : "";


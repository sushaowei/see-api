<?php
/**
 * Created by PhpStorm.
 * User: ch168mk
 * Date: 16/7/4
 * Time: 下午5:08
 */
define("ROOT",__DIR__);
set_time_limit(0);
require __DIR__ . '/vendor/autoload.php';
$config = require('./config/console.php');

$app = new \see\console\Application($config);
$app->run($argv);

<?php

define('BASEPATH', dirname(__DIR__));

$app = App\System\App::getInstance(BASEPATH);

$config = new \App\System\Config\Config('config');
$config->addConfig('database.yaml');
$config->addConfig('app.yaml');

$app->add('config', $config);

if (true === \App\Helpers\AppHelper::config('system.orm')) {
    $orm = new \App\System\Database\Orm(\App\Helpers\AppHelper::config('database'));
    $app->add('orm', $orm);
}
return $app;

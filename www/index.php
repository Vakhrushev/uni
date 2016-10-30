<?php
session_start();
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Uni', __DIR__ . '/../src/');

$conf = \Uni\Prj\Config::getInstance();
$conf->setRoot(__DIR__);
$conf
	->set(DB_TYPE, 'mysql')
	->set(DB_HOST, 'mysql')
	->set(DB_NAME, 'uni')
	->set(DB_USER, 'test')
	->set(DB_PASS, 'test');
$app = new Uni\App($conf);
$app->start();


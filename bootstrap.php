<?php

define('APP_DIR', __DIR__.DIRECTORY_SEPARATOR);

require 'vendor/autoload.php';

define('APP_DIR', __DIR__.DIRECTORY_SEPARATOR);
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
date_default_timezone_set('Asia/Dhaka');
session_start();

$app = new \Slim\App();

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(APP_DIR.'templates', [
        'cache' => APP_DIR.'tmp/cache'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};
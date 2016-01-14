<?php
session_start();
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
date_default_timezone_set('Asia/Dhaka');

define('APP_DIR', __DIR__ . DIRECTORY_SEPARATOR);
require 'vendor/autoload.php';

$app = new \Slim\App();

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        APP_DIR . 'templates',
        [
            'cache' => APP_DIR . 'tmp/cache',
            'debug' => true,
            'auto_reload' => true,
        ]
    );
    $view->addExtension(
        new \Slim\Views\TwigExtension(
            $container['router'],
            $container['request']->getUri()
        )
    );

    return $view;
};

// Register flash provider
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

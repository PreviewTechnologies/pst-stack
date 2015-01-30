<?php
define('APP_DIR', __DIR__.DIRECTORY_SEPARATOR);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
date_default_timezone_set('Asia/Dhaka');
session_start();

require APP_DIR.'vendor/autoload.php';

require_once APP_DIR.'propel/generated-conf/config.php';

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => APP_DIR.'templates',
));

// Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler(APP_DIR.'tmp/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath(APP_DIR.'tmp/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());
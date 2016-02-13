<?php
#session start
session_start();

#dependencies included via composer autoload
require '../vendor/autoload.php';

$conf = \Noodlehaus\Config::load(__DIR__ . DIRECTORY_SEPARATOR . 'settings.php');

#encoding
mb_internal_encoding($conf['app.encoding.mb_internal_encoding']);
mb_http_output($conf['app.encoding.mb_http_output']);

#timezone
date_default_timezone_set($conf['app.timezone']);

#Database Configuration
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass($conf['app.namespace'], 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration([
    'dsn' => 'mysql:host=' . $conf['app.db.host'] . ';port=' . $conf['app.db.port'] . ';dbname=' . $conf['app.db.name'],
    'user' => $conf['app.db.username'],
    'password' => $conf['app.db.password'],
    'settings' =>
        [
            'charset' => $conf['app.db.charset'],
            'queries' => [],
        ],
    'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
]);
$manager->setName($conf['app.namespace']);
$serviceContainer->setConnectionManager($conf['app.namespace'], $manager);
$serviceContainer->setDefaultDatasource($conf['app.namespace']);
# End of Propel Database


#SLIM instantiate
$app = new \Slim\App();
$container = $app->getContainer();
$container['view'] = function ($container) use ($conf) {
    $view = new \Slim\Views\Twig(
        $conf['app.template.dir'],
        [
            'cache' => $conf['app.template.cache'],
            'debug' => $conf['app.template.debug'],
            'auto_reload' => $conf['app.template.auto_reload'],
        ]
    );
    $view->addExtension(
        new \Slim\Views\TwigExtension(
            $container['router'],
            $container['request']->getUri()
        )
    );
    $view->addExtension(
        new Twig_Extension_Debug()
    );
    $view->offsetSet('userGlobalData', App::getUser());

    return $view;
};
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
#End of SLIM Instance
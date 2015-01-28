<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('twitter', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=localhost;dbname=twitter',
  'user' => 'root',
  'password' => 'ltqpsmr7',
));
$manager->setName('twitter');
$serviceContainer->setConnectionManager('twitter', $manager);
$serviceContainer->setDefaultDatasource('twitter');
$serviceContainer->setLoggerConfiguration('defaultLogger', array (
  'type' => 'stream',
  'path' => '/var/log/propel.log',
  'level' => '300',
));
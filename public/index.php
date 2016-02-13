<?php
//Application Bootstrap file
require dirname(__DIR__).DIRECTORY_SEPARATOR.'config/bootstrap.php';

$pst = new \PstStack\Utility\Utility();
var_dump($pst->test()); die();

//All routes
require "../routes/default.php";

//Run the application
$app->run();
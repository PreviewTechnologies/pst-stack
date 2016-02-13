<?php
//Application Bootstrap file
require dirname(__DIR__).DIRECTORY_SEPARATOR.'config/bootstrap.php';

//All routes
require "../routes/default.php";

//Run the application
$app->run();
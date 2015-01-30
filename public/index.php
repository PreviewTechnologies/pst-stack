<?php
require "../bootstrap.php";

//some common functions for using within anywhere in the application

function requireLogin()
{
    if (!App::userLoggedIn()) {
        $app = \Slim\Slim::getInstance();
        $app->flash('error', 'You must be logged in to access that page');
        $app->redirect('/login');
    }
}

require "../routes/default.php";

$app->run();
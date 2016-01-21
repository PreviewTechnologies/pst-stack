<?php
require "../bootstrap.php";

//create middleware here if needed ( not global)

/*$t1 = function ($request, $response, $next) {

    if (!App::userLoggedIn()) {
        return $response->withStatus(301)->withHeader('Location', 'login');

    }else {
        $response = $next($request, $response);
        return $response;
    }
};*/


require "../routes/default.php";

$app->run();
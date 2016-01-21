<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/20/16
 * Time: 6:41 PM
 */
class AuthMiddleware
{
    public function __invoke($request, $response, $next)
    {
        if (!App::userLoggedIn()) {
            return $response->withStatus(301)->withHeader('Location', 'login');

        }else {
            $response = $next($request, $response);
            return $response;
        }
    }
}
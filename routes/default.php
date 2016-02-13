<?php

$app->get('/', function ($request, $response, $args) {

    return $this->view->render($response, 'home.twig',
        [
        ]
    );
})->add(new AuthMiddleware());

$app->get('/login', function ($request, $response, $args) {
    return $this->view->render($response, 'login.twig',
        [

        ]
    );
});

$app->post(
    '/login',
    function ($request, $response, $args) {
        $data = $request->getParsedBody();

        $emailAddress = strtolower(filter_var($data['email'], FILTER_SANITIZE_STRING));

        $password = filter_var($data['password'], FILTER_SANITIZE_STRING);

        if ($user = UserQuery::create()->filterByEmail($emailAddress)->findOne()) {

            if (password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user->getUUID();

                return $response->withRedirect('/');
            } else {
                $this->flash->addMessage('error', 'Invalid email address and/or password');

                return $response->withRedirect('login');
            }
        } else {
            $this->flash->addMessage('error', 'Invalid email address and/or password');

            return $response->withRedirect('login');
        }
    }
);

$app->get('/signup', function ($request, $response, $args) {

    if (App::userLoggedIn()) {
        /*
         * @TODO need to redirect into login page.
         */
    }

    return $this->view->render($response, 'signup.twig',
        [

        ]
    );
});

$app->post(
    '/signup',
    function ($request, $response, $args) {
        $data = $request->getParsedBody();

        $emailAddress = strtolower(filter_var($data['email'], FILTER_SANITIZE_STRING));
        $password = filter_var($data['password'], FILTER_SANITIZE_STRING);
        $firstName = filter_var($data['firstName'], FILTER_SANITIZE_STRING);
        $lastName = filter_var($data['lastName'], FILTER_SANITIZE_STRING);

        $user = new User();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($emailAddress);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $user->setUUID(UUID::v4());
        if ($user->save()) {
            $this->flash->addMessage('info', 'Signup successful. You may login now!');

            return $response->withRedirect('login');
        } else {
            $this->flash->addMessage('error', 'Sorry, something went wrong');

            return $response->withRedirect('signup');
        }
    }
);

$app->get('/logout', function ($request, $response, $args) {
    unset($_SESSION['user']);

    return $response->withRedirect('login');
});
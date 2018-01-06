<?php

/*
|----------------------------------------------------
| Routing sytem                                     |
|----------------------------------------------------
*/

/*
|-----------------------------------------------------
| For html view (home and reset password)            |
|-----------------------------------------------------
|
| Route version without controller (example)
|
| $app->get('/', function($request, $response){
|     Menampilkan twig template
|     return $this->view->render($response, 'home.twig');
| });
*/

    //route with controller
    $app->get('/', 'DefaultController:index')->setName('home');
    $app->get('/reset{token}', 'DefaultController:resetPassword')->setName('reset');

/*
|----------------------------------------------------
| Api                                               |
|----------------------------------------------------
*/

    //---------------------- Example APIs ------------------------------

        //Api for test (ExampleCrud Controller)
        $app->get('/example', 'ExampleCrud:index');
        $app->get('/example/api/v1/datas', 'ExampleCrud:datas'); // get all
        $app->get('/example/api/v1/data/{id}', 'ExampleCrud:data'); // get by id
        $app->post('/example/api/v1/create/data', 'ExampleCrud:create'); //create with name
        $app->post('/example/api/v1/update/data', 'ExampleCrud:update'); //create with name
        $app->post('/example/api/v1/delete/data/{id}', 'ExampleCrud:delete'); //delete by id

    //---------------------- Example APIs ------------------------------


/*
|----------------------------------------------------
| User data and Authentication                      |
|----------------------------------------------------
| Data and Auth
| Version 1.0
|
*/
    //Auth API
    $app->post('/api/v1/auth/signup', 'AuthController:postSingUp');
    $app->post('/api/v1/auth/signin', 'AuthController:postSingIn');

    //User API
    $app->post('/api/v1/user/detail', 'UserController:postUserDetail');
    $app->post('/api/v1/user/password/forgot', 'UserController:postForgotPassword');
    $app->post('/api/v1/user/password/change', 'UserController:postChangePassword');
    $app->get('/api/v1/user/token/{id}', 'UserController:getTokenById');
    $app->get('/api/v1/user/token/validation/{token}', 'UserController:isValidToken');

    //For Test new method
    $app->get('/api/test', 'LocationServiceController:getLocation');
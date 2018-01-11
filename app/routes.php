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
| Rest API Routes                                   |
|----------------------------------------------------
| Rest Routes
| Version 1.0
|
*/
    //Auth API
    $app->post('/v1.0/user/auth/signup', 'UserAuthController:postSingUp');
    $app->post('/v1.0/user/auth/signin', 'UserAuthController:postSingIn');

    //User API
    $app->post('/v1.0/user/data/detail', 'UserDataController:postUserDetail');
    $app->post('/v1.0/user/data/password/forgot', 'UserDataController:postForgotPassword');
    $app->post('/v1.0/user/data/password/change', 'UserDataController:postChangePassword');
    $app->get('/v1.0/user/data/token/{id}', 'UserDataController:getTokenById');

    //Location
    $app->get('/v1.0/place/location/list', 'LocationServiceController:getPlaceByCategory');
    $app->get('/v1.0/place/location/detail', 'LocationServiceController:getPlaceDetail');

    //For Test new method
    $app->post('/api/test', 'LocationServiceController:getPlaceByCategory');


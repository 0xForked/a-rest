<?php

    use Respect\Validation\Validator as V;

    //Start session
    session_start();


/*
|----------------------------------------------------
| Menginisialisasi direktori autoload               |
|----------------------------------------------------
|
| untuk meload kelas yang ada dalam folder vendor
|
*/

    require __DIR__ . ('/../vendor/autoload.php');

/*
|----------------------------------------------------
| Slim Framework                                    |
|----------------------------------------------------
|
| inisialisasi settings untuk framework ini
|
*/

    $app = new \Slim\App([
        'settings' => [
            'displayErrorDetails' => true,
            'db' => [
                'driver'        => 'mysql',
                'host'          => 'localhost',
                'database'      => 'asmith_rest',
                'username'      => 'root',
                'password'      => '',
                'charset'       => 'utf8',
                'collation'     => 'utf8_unicode_ci',
                'prefix'        => '',
            ]
        ]

    ]);


/*
|----------------------------------------------------
| Bagian Container                                  |
|----------------------------------------------------
*/

    //Pangil si container
    $container = $app->getContainer();

    //Setting koneksi Eloquent
    $capsule =  new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    //Container untuk Eloquent - illuminate database
    $container['db'] = function($container) use ($capsule){
        return $capsule;
    };

    //Container menghandle View dengan Twig
    $container['view'] = function ($container) {
        //Twig file Folder
        $view = new \Slim\Views\Twig(
            __DIR__ . '/../resources/view/template/',
            [ 'cache' => false ]
        );

        // Instantiate and add Slim specific extension
        $basePath = rtrim(str_ireplace('index.php', '',
            $container['request']->getUri()->getBasePath()), '/'
        );

        $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

        return $view;
    };

    //Container menghandle error 404
    $container['notFoundHandler'] = function ($container){
        return function ($request, $response) use ($container) {
            return $container->view->render($response, 'error_404.twig');

        };
    };

    //Container untuk Validator
    $container['validator'] = function ($container) {
        return new \App\Validation\Validator($container);
    };


    //Controller
    $container['DefaultController'] = function ($container) {
        return new \App\Controllers\DefaultController($container);
    };

    $container['ExampleCrud'] = function ($container) {
        return new \App\Controllers\ExampleCrud($container);
    };

    $container['AuthController'] = function ($container) {
        return new \App\Controllers\Auth\AuthController($container);
    };

    //Middleware
    $app->add(new \App\Middleware\ValidationErrorsMiddlerware($container));

    //Validation
    V::with('App\\Validation\\Rules\\');



/*
|----------------------------------------------------
| File Router                                       |
|----------------------------------------------------
*/

    require __DIR__  . ('/../app/routes.php');
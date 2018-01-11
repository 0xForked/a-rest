<?php

    use Respect\Validation\Validator as ValidationRules;
    use PHPMailer\PHPMailer\PHPMailer;

    //Start session for php session
    session_start();


/*
|----------------------------------------------------
| Register The Auto Loader
|----------------------------------------------------
*/

    require __DIR__ . ('/../vendor/autoload.php');

/*
|----------------------------------------------------
| Slim Framework Setting                            |
|----------------------------------------------------
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


    //Add Container
    $container = $app->getContainer();

/*
|----------------------------------------------------
| Eloquent                                          |
|----------------------------------------------------
*/

    //Eloquent Setting
    $capsule =  new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

/*
|----------------------------------------------------
|  View                                             |
|----------------------------------------------------
*/

    $container['view'] = function ($container) {
        //Template Folder
        $view = new \Slim\Views\Twig(
            __DIR__ . '/../resources/view/template/',
            [ 'cache' => false ]
        );

        // Add Slim specific extension
        $basePath = rtrim(str_ireplace('index.php', '',
            $container['request']->getUri()->getBasePath()), '/'
        );

        //Add route extension
        $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

        //return view
        return $view;
    };

    //Container for error 404
    $container['notFoundHandler'] = function ($container){
        return function ($request, $response) use ($container) {
            return $container->view->render($response, 'error_404.twig');

        };
    };

/*
|----------------------------------------------------
|  Validator                                        |
|----------------------------------------------------
*/

    $container['validator'] = function ($container) {
        return new \App\Validation\Validator($container);
    };

    //Validation Rules
    ValidationRules::with('App\\Validation\\Rules\\');

/*
|----------------------------------------------------
|  Mailer                                           |
|----------------------------------------------------
*/

    $container['mailer'] = function ($container) {
        $mailer = new PHPMailer();

        //$mailer->SMTPDebug = 3;

        $mailer->isSMTP();

        $mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //$mailer->Host = 'tsl://smtp.gmail.com:587';
        $mailer->Host = 'ssl://smtp.gmail.com:465';

        $mailer->SMTPAuth = true;
        $mailer->Username = 'fookipoke@gmail.com';
        $mailer->Password = 'fookipoke.password';

        $mailer->setFrom('fookipoke@gmail.com', 'FookiPoke Studio');

        $mailer->isHtml(true);

        return new \App\Maillers\Mailer($container->view, $mailer);

    };

/*
|----------------------------------------------------
|  Controller                                       |
|----------------------------------------------------
*/

    $container['DefaultController'] = function ($container) {
        return new \App\Controllers\DefaultController($container);
    };

    $container['ExampleCrud'] = function ($container) {
        return new \App\Controllers\ExampleCrud($container);
    };

    $container['UserAuthController'] = function ($container) {
        return new \App\Controllers\User\UserAuthController($container);
    };

    $container['UserDataController'] = function ($container) {
        return new \App\Controllers\User\UserDataController($container);
    };

    $container['LocationServiceController'] = function ($container) {
        return new \App\Controllers\Location\LocationServiceController($container);
    };


/*
|----------------------------------------------------
|  Middleware                                       |
|----------------------------------------------------
*/

    $app->add(new \App\Middleware\ValidationErrorsMiddlerware($container));


/*
|----------------------------------------------------
| File Router                                       |
|----------------------------------------------------
*/

    require __DIR__  . ('/../app/routes.php');
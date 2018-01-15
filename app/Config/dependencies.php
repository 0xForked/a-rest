<?php

//Use the library
use Respect\Validation\Validator as ValidationRules;
use PHPMailer\PHPMailer\PHPMailer;

/*
|----------------------------------------------------
| Container                                         |
|----------------------------------------------------
*/

    $container = $app->getContainer();

/*
|----------------------------------------------------
| ORM                                               |
|----------------------------------------------------
*/

    $capsule =  new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

/*
|----------------------------------------------------
| View Template                                     |
|----------------------------------------------------
*/

    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig(
            __DIR__ . '/../../resources/view/',
            [ 'cache' => false ]
        );

        $basePath = rtrim(str_ireplace('index.php', '',
            $container['request']->getUri()->getBasePath()), '/'
        );

        $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

        return $view;
    };

     $container['notFoundHandler'] = function ($container){
        return function ($request, $response) use ($container) {
            return $container->view->render($response, 'error_404.twig');

        };
    };

/*
|----------------------------------------------------
| Validator                                         |
|----------------------------------------------------
*/

    $container['validator'] = function ($container) {
        return new \App\Validation\Validator($container);
    };

    ValidationRules::with('App\\Validation\\Rules\\');

/*
|----------------------------------------------------
| Mailer                                            |
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

        return new \App\Mailers\Mailer($container->view, $mailer);

    };

/*
|----------------------------------------------------
| Controller                                        |
|----------------------------------------------------
*/

    $container['DefaultController'] = function ($container) {
        return new \App\Controllers\DefaultController($container);
    };

    $container['UserAuthController'] = function ($container) {
        return new \App\Controllers\User\UserAuthController($container);
    };

    $container['UserDataController'] = function ($container) {
        return new \App\Controllers\User\UserDataController($container);
    };


/*
|----------------------------------------------------
| Middleware                                        |
|----------------------------------------------------
*/

    $app->add(new \App\Middleware\ValidationErrorsMiddlerware($container));
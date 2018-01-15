<?php

    //Start php session
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

    $settings = require __DIR__ . '/../app/config/settings.php';
    $app = new \Slim\App($settings);

/*
|----------------------------------------------------
| File dependencies                                 |
|----------------------------------------------------
*/

    require __DIR__  . ('/../app/config/dependencies.php');

/*
|----------------------------------------------------
| File Router                                       |
|----------------------------------------------------
*/

    require __DIR__  . ('/../app/routes.php');
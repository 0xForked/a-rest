<?php

    namespace App\Controllers;

    class DefaultController extends Controller {

        public function index($request, $response){
             //Show twig template
            return $this->view->render($response, 'home.twig');
        }

        public function resetPassword($request, $response){
             //Show twig template
            return $this->view->render($response, 'change_password.twig');
        }
    }
<?php

    namespace App\Controllers;

    class DefaultController extends Controller {

        public function index($request, $response){
             //Menampilkan twig template
            return $this->view->render($response, 'home.twig');
        }
    }
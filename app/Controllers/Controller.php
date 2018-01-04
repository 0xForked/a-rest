<?php

    namespace App\Controllers;

    class Controller {

        protected $container;

        public function __construct($container){

            $this->container = $container;
        }

        public function __get($property){

            if ($this->container{$property}){
                return $this->container->{$property};
            }
        }

        //Generate random md5 keys
        public function generateKey() {
            //return unique md5 random key
            return md5(uniqid(rand(), true));

        }

    }
<?php

    namespace App\Validation\Exceptions;
    use Respect\Validation\Exceptions\ValidationException;

    class CityAvailableException extends ValidationException {

        public static $defaultTemplates = [

            self::MODE_DEFAULT => [

                self::STANDARD => 'Your city is currently not in our database',

            ],
        ];

    }
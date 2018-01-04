<?php

    namespace App\Validation\Exceptions;
    use Respect\Validation\Exceptions\ValidationException;

    class MatchesTokenException extends ValidationException {

        public static $defaultTemplates = [

            self::MODE_DEFAULT => [

                self::STANDARD => 'Token does not match.',

            ],
        ];

    }
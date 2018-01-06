<?php

    namespace App\Validation\Exceptions;
    use Respect\Validation\Exceptions\ValidationException;

    class PlaceCategoryAvailableException extends ValidationException {

        public static $defaultTemplates = [

            self::MODE_DEFAULT => [

                self::STANDARD => 'Category is not available',

            ],
        ];

    }
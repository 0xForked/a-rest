<?php

    namespace App\Validation\Rules;
    use Respect\Validation\Rules\AbstractRule;
    use App\Models\Location\LocationCity;

    class CityAvailable extends AbstractRule {

        public function __construct(){
           return true;
        }

        public function validate($input) {

            return LocationCity::where('name', $input)->count() === 1;

        }

    }
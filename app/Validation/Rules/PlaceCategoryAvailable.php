<?php

    namespace App\Validation\Rules;
    use Respect\Validation\Rules\AbstractRule;
    use App\Models\Location\PlaceCategory;

    class PlaceCategoryAvailable extends AbstractRule {

        public function __construct(){
            return "Place Category Rules";
         }

        public function validate($input) {

            return PlaceCategory::where('category_name', $input)->count() !== 0;

        }

    }
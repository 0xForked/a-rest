<?php

    namespace App\Validation\Rules;
    use Respect\Validation\Rules\AbstractRule;
    use App\Models\User\UsersModel;

    class MatchesToken extends AbstractRule {

        public function validate($input) {

            return UsersModel::where('api_token', $input)->count() !== 0;

        }

    }
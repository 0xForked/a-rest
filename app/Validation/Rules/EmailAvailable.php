<?php

    namespace App\Validation\Rules;
    use Respect\Validation\Rules\AbstractRule;
    use App\Models\User\UsersModel;

    class EmailAvailable extends AbstractRule {

        public function validate($input) {

            return UsersModel::where('email', $input)->count() === 0;

        }

    }
<?php

namespace App\Controllers\User;
use App\Controllers\Controller;
use App\Models\User\UsersModel;
use App\Models\User\UsersGroup;
use App\Models\User\UsersDetail;
use App\Models\User\GroupModel;
use Respect\Validation\Validator as V;
use PHPMailer\PHPMailer\PHPMailer;

class UserDataController extends Controller {

 	/**
    * Fetching user data by id and token
    * @param String $id $token
    */
    public function postUserDetail($request, $response){
        //get token and uid
        $uid = $request->getParam('uid');
        $token = $request->getParam('token');

        //cek database and get user
        $user_main = UsersModel::where('id', $uid)
                            ->where('api_token', $token)
                            ->first();

        //if user not null
        if (isset($user_main)) {

            $user_detail = UsersDetail::where('user_id', $user_main->id)->first();
            $user_group = UsersGroup::where('user_id', $user_main->id)->first();
            $groups = GroupModel::where('id', $user_group->group_id)->first();

            //Return respon message true if user login !failed
            return $response->withJson(array(
                'status'   => 200,
                'error'    => false,
                'message'  => 'Success',
                'user' => [
                    'uid'       => $user_main->id,
                    'token'     => $user_main->api_token,
                    'name'      => $user_detail->full_name,
                    'username'  => "@".$user_main->username,
                    'phone'     => $user_detail->phone,
                    'email'     => $user_main->email,
                    'group'     => $groups->name,

                ]
            ),200);

        } else {

            //Return respon message false if store user failed
            return $response->withJson(array(
                'status' => 400,
                'error' => true,
                'message' => 'Cannot retrieve user data user token or user id is wrong'
            ),400);

        }

    }

 	/**
    * Change password user
    * @param String $uid $token
    */
    public function postChangePassword($request, $response){
    	//Get parameter
        $uid = $request->getParam('uid');
        $token = $request->getParam('token');

        //cek database and get user
        $user_main = UsersModel::where('id', $uid)
                                ->where('api_token', $token)
                                ->first();

        //validate input
        $validation =  $this->validator->validate($request, [
            'password_old'      => V::noWhiteSpace()->notEmpty()
                                    ->matchesPassword($user_main->password),
            'password_new'      => V::noWhiteSpace()->notEmpty(),
        ]);

        //cek validation
        if($validation->failed()){
            return $response->withJson(array(
                'errors' => $_SESSION['errors']
            ),400);
        }

        //set password
        if ($user_main) {

            $password = $request->getParam('password_new');
            UsersModel::where('id', $uid)
                        ->where('api_token', $token)
                        ->update([
                'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 10])
            ]);

            //Return respon message true password success changed
            return $response->withJson(array(
                'status' => 201,
                'error' => false,
                'message' => 'Change password success'
            ),201);

        }

    }

	/**
    * Forgot password user
    * @param String $email
    */
 	public function postForgotPassword($request, $response){
        $email = $request->getParam('email');
        $query = UsersModel::find($email);

        //validate input
        $validation =  $this->validator->validate($request, [
            'email'   => V::noWhiteSpace()->notEmpty()->email(),
        ]);

        //cek validation
        if($validation->failed()){
            return $response->withJson(array(
                'errors' => $_SESSION['errors']
            ),400);
        }

        //Update new code
        $forgot = UsersModel::where('email', $email)->update([
            'forgotten_password_code' => Controller::generateKey(),
            'forgotten_password_time' => time()
        ]);


        if($forgot) {

            $user_main = UsersModel::where('email', $email)->first();
            $user_detail = UsersDetail::where('user_id', $user_main->id)->first();

            $this->mailer->send('email/forgot_message.twig',
                                ['forgotcode' => $user_main->forgotten_password_code,
                                 'fullname' => $user_detail->full_name ],
                                function($message) use ($user_main){

                $subject = "Some App - Forgot password";
                $message->to($user_main->email);
                $message->subject($subject);

            });

            return $response->withJson(array(
                'status' => 201,
                'error' => false,
                'message' => 'Success send email',
            ),201);

        } else {
            //Error response
            return $response->withJson(array(
                'status' => 400,
                'error' => true,
                'message' => 'Failed send a email, your email is not in our databases',
            ),400);
        }

    }

    /**
    * Fetching user api key
    * @param String $user_id user id primary key in user table
    */
    public function getTokenById($request, $response) {
        //get user input
        $user_id = $request->getAttribute('id');

        //cek database and get api token
        $user = UsersModel::where('id', $user_id)
                                ->select('api_token')
                                ->first();

        //cek if !user
        if (isset($user)) {

            //give response message error false
            return $response->withJson(array(
                'status' => 200,
                'error' => false,
                'message' => 'Success',
                'token' => $user->api_token
            ),200);

        } else {

            //give response message error true
            return $response->withJson(array(
                'status' => 400,
                'error' => true,
                'message' => 'Cannot retrieve user Token'
            ),400);

        }
    }

    /**
    * Validating user api key
    * @param String $api_token user api token
    * @return boolean
    */
    private function isValidToken($token) {
        //get input
        //$token = $request->getAttribute('token');

        //cek validation api token
        $user = UsersModel::where('api_token', $token)->first();

        return isset($user);

    }

}
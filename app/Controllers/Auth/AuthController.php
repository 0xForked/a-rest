<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;
use App\Models\User\UsersModel;
use App\Models\User\UsersGroup;
use App\Models\User\GroupModel;
use Respect\Validation\Validator as V;

class AuthController extends Controller {

    /**
    * Register new user
    * @param String
    */
    public function postSingUp($request, $response){

        try{

            //validate input
            $validation =  $this->validator->validate($request, [
                'name'          => V::notEmpty()->alpha(),
                'email'         => V::noWhiteSpace()->notEmpty()
                                    ->email()->emailAvailable(),
                'password'      => V::noWhiteSpace()->notEmpty(),
            ]);

            //cek validation
            if($validation->failed()){
                return $response->withJson(array(
                        'errors' => $_SESSION['errors']
                ),401);
            }

            // Generating API key
            $api_token = $this->generateApiKey();

            //Store user data if validate !failed
            UsersModel::create([
                'name'          => $request->getParam('name'),
                'email'         => $request->getParam('email'),
                'password'      => password_hash($request->getParam('password'),
                                    PASSWORD_BCRYPT, ['cost' => 10]),
                'api_token'     => $api_token
            ]);

            //Return respon message true if store user !failed
            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'success'
            ),201);

        }catch(\Exception $e){

            //error handle if postSingUp failed to execute
            return $response->withJson(array(
                'error' => $e->getMessage()
            ),401);

        }

    }

    /**
    * Login user by email and password
    * @param String $email, $password
    */

    public function postSingIn($request, $response){
        //Get input parameter
        $email      = $request->getParam('email');
        $password   = $request->getParam('password');

        //validate input
        $validation =  $this->validator->validate($request, [
            'email'         => V::noWhiteSpace()->notEmpty()->email(),
            'password'      => V::noWhiteSpace()->notEmpty(),
        ]);

        //cek validation
        if($validation->failed()){
            return $response->withJson(array(
                    'errors' => $_SESSION['errors']
            ),401);
        }

        //cek user
        $user = UsersModel::where('email', $email)->first();

        //if user and user email failed to fetch
        if (!$user){
            if($user->email == null) {
                //response false if !email
                return $response->withJson(array(
                    'status' => '400',
                    'error' => true,
                    'message' => 'Login gagal, Periksa kembali email anda',
                ),400);
            }
        }

        //decrypt password
        if(password_verify($password, $user->password)){
            //diperlukan untuk test pada bagian reset password secara lokal
            //bisa dihapus ketika api di konsumsi dari client
            $_SESSION['user_id'] = $user->id;

             // Generating new API key
            $api_token = $this->generateApiKey();

            //Update new token
            UsersModel::where('email', $email)->update(
                ['api_token' => $api_token]
            );

            $user_group = UsersGroup::where('user_id', $user->id)->first();
            $groups = GroupModel::where('id', $user_group->group_id)->first();
            $user_group = $groups->name;

            //Return respon message true if user login !failed
            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'Berhasil Login',
                'user_id' =>  $user->id,
                'user' => [
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_group' => $user_group
                ]
            ),201);

        }

        //return false if !password
        return $response->withJson(array(
            'status' => '400',
            'error' => true,
            'message' => 'Login gagal, Periksa kembali password anda',
        ),400);

    }


    /**
    * Change password user
    * @param String $password old and new
    */
    public function postChangePassword($request, $response){

        //validate input
        $validation =  $this->validator->validate($request, [
            'password_old'      => V::noWhiteSpace()->notEmpty()
                                    ->matchesPassword($this->user()->password),
            'password_new'      => V::noWhiteSpace()->notEmpty(),
        ]);

        //cek validation
        if($validation->failed()){
            return $response->withJson(array(
                'errors' => $_SESSION['errors']
            ),401);
        }

        //access SetPassword function with passing new password
        $this->user()->setPassword($request->getParam('password_new'));

        //Return respon message true password success changed
        return $response->withJson(array(
            'status' => '201',
            'error' => false,
            'message' => 'change password success'
        ),201);

    }


    /**
    * Fetching user by email
    * @param String $email User email id
    */
    public function getUserByEmail($request, $response){
        //get email input
        $email = $request->getParam('email');

        //cek database and get user
        $user = UsersModel::where('email', $email)
                            ->select('name', 'email', 'api_token')
                            ->first();

        //if !user
        if (isset($user)) {
            //response error true
            return $response->withJson($user);
        } else {

            //Return respon message false if store user failed
            return $response->withJson(array(
                'status' => '401',
                'error' => true,
                'message' => 'Tidak dapat mengambil data user'
            ),401);

        }

    }

    /**
    * Fetching user api key
    * @param String $user_id user id primary key in user table
    */
    public function getApiKeyById($request, $response) {
        //get user input
        $user_id = $request->getParam('id');

        //cek dataase and get api token
        $user = UsersModel::where('id', $user_id)
                                ->select('api_token')
                                ->first();

        //cek if !user
        if (isset($user)) {

            //give response message error false
            return $response->withJson($user);

        } else {

            //give response message error true
            return $response->withJson(array(
                'status' => '401',
                'error' => true,
                'message' => 'Tidak dapat mengambil data user'
            ),401);

        }
    }


    /**
    * Fetching user id by api key
    * @param String $api_key user api key
    */
    public function getUserId($request, $response) {
        //get api key input
        $api_key = $request->getParam('api_token');

        //get id from db
        $user = UsersModel::where('api_token', $api_key)
                            ->select('id')
                            ->first();

        //cek if !user
        if (isset($user)) {

            //give response message error false
            return $response->withJson($user);

        } else {

            //give response message error true
            return $response->withJson(array(
                'status' => '401',
                'error' => true,
                'message' => 'Tidak dapat mengambil data user'
            ),401);

        }
    }


    /**
    * Validating user api key
    * If the api key is there in db, it is a valid key
    * @param String $api_key user api key
    * @return boolean
    */
    public function isValidApiKey($request, $response) {
        //get input
        $api_key = $request->getParam('api_token');

        //cek validation api token
        $user = UsersModel::where('api_token', $api_key)
                            ->select('id')
                            ->first();

        if (isset($user)) {
            //give response message error false
            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'API Token isValid'
            ),201);

        } else {
            //give response message error true
            return $response->withJson(array(
                'status' => '401',
                'error' => true,
                'message' => 'API Token inValid'
            ),401);

        }
    }

//===================================== fungsi penunjang =========================

    //Generate random md5 api token
    private function generateApiKey() {
        //return unique md5 random key
        return md5(uniqid(rand(), true));

    }

    public function user(){

        if (isset($_SESSION['user_id'])){

            return UsersModel::find($_SESSION['user_id']);

        }

    }

}
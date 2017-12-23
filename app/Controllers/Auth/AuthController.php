<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;
use App\Models\User\UsersModel;
use App\Models\User\UsersGroup;
use App\Models\User\UsersDetail;
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
                'full_name'     => V::notEmpty()->alpha(),
                'username'      => V::noWhiteSpace()->notEmpty(),
                'email'         => V::noWhiteSpace()->notEmpty()
                                    ->email()->emailAvailable(),
                'phone'         => V::noWhiteSpace()->notEmpty(),
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
            //Get input email
            $email = $request->getParam('email');
            //Get input email
            $username = $request->getParam('username');
            //Get name
            $name = $request->getParam('full_name');
            //Get phone
            $phone = $request->getParam('phone');
            //Default user group is 2 (member)
            $default_group = 2;
            //account status 1(active)
            $account_status = 1;

            //Store user data if validate !failed
            $new_user = UsersModel::create([
                            'email'         => $email,
                            'username'      => $username,
                            'password'      => password_hash($request->getParam('password'),
                                                PASSWORD_BCRYPT, ['cost' => 10]),
                            'api_token'     => $api_token,
                            'active'        => $account_status
                        ]);

            //Create user group if success create new user
            if($new_user){

                //cek user
                $user = UsersModel::where('email', $email)->first();

                //create defaul group for new user
                UsersGroup::create([
                    'user_id'       => $user->id,
                    'group_id'      => $default_group,

                ]);
                //create user detail
                UsersDetail::create([
                    'user_id'       => $user->id,
                    'full_name'     => $name,
                    'phone'         => $phone,
                ]);

            }

            //Return respon message true if store user !failed
            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'success',
                'user' => [
                    'uid'       => $user->id,
                    'token'     => $user->api_token,
                    'name'      => $user_detail->full_name,
                    'username'  => "@".$user_main->username,
                    'phone'     => $user_detail->phone,
                    'email'     => $user_main->email,
                    'group'     => $groups->name,
                ]
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
        if (!$user && $user->email == null){

            //response false if !email
            return $response->withJson(array(
                'status' => 400,
                'error' => true,
                'message' => 'Login failed, Please cek your email address',
            ),400);

        }

        //decrypt password
        if(password_verify($password, $user->password)){
            //diperlukan untuk test pada bagian reset password secara lokal
            //bisa dihapus ketika api di konsumsi dari client
            $_SESSION['user_id'] = $user->id;

             // Generating new API key
            $api_token = $this->generateApiKey();

            //Update new token
            $tokens = UsersModel::where('email', $email)->update(
                ['api_token' => $api_token]
            );

            if($tokens) {
                //get new user token
                $user_main = UsersModel::where('email', $email)->first();
                 //Get user group
                $user_group = UsersGroup::where('user_id', $user_main->id)->first();
                //Get group by user group
                $groups = GroupModel::where('id', $user_group->group_id)->first();
                //get user detail
                $user_detail = UsersDetail::where('user_id', $user_main->id)->first();

                 //Return respon message true if user login !failed
                return $response->withJson(array(
                    'status'   => 201,
                    'error'    => false,
                    'message'  => 'Berhasil Login',
                    'user' => [
                        'uid'       => $user->id,
                        'isActive'  => $user_main->active,
                        'token'     => $user_main->api_token,
                    ]
                ),201);
            }


        }

        //return false if !password
        return $response->withJson(array(
            'status' => 400,
            'error' => true,
            'message' => 'Login failed, Please cek your password',
        ),400);

    }

    /**
    * Change password user
    * @param String $password old and new
    */
    public function postChangePassword($request, $response){

        $uid = $request->getParam('uid');
        $query = UsersModel::find($uid);

        //validate input
        $validation =  $this->validator->validate($request, [
            'password_old'      => V::noWhiteSpace()->notEmpty()
                                    ->matchesPassword($query->password),
            'password_new'      => V::noWhiteSpace()->notEmpty(),
        ]);

        //cek validation
        if($validation->failed()){
            return $response->withJson(array(
                'errors' => $_SESSION['errors']
            ),401);
        }

        //access SetPassword function with passing new password
        $query->setPassword($request->getParam('password_new'));

        //Return respon message true password success changed
        return $response->withJson(array(
            'status' => 201,
            'error' => false,
            'message' => 'change password success'
        ),201);

    }

    public function postForgotPassword($request, $response){
        //Do something :v
    }


    /**
    * Fetching user by id and token
    * @param String $email User email id
    */
    public function postUserDetail($request, $response){
        //get token and uid
        $uid = $request->getParam('uid');
        $token = $request->getParam('token');

        //cek database and get user
        $user_main = UsersModel::where('id', $uid)
                            ->where('api_token', $token)
                            ->first();

        //if !user
        if (isset($user_main)) {

            $user_detail = UsersDetail::where('user_id', $user_main->id)->first();
            $user_group = UsersGroup::where('user_id', $user_main->id)->first();
            $groups = GroupModel::where('id', $user_group->group_id)->first();

            //Return respon message true if user login !failed
            return $response->withJson(array(
                'status'   => 201,
                'error'    => false,
                'message'  => 'Success',
                'user' => [
                    'uid'       => $user_main->id,
                    'name'      => $user_detail->full_name,
                    'username'  => "@".$user_main->username,
                    'phone'     => $user_detail->phone,
                    'email'     => $user_main->email,
                    'group'     => $groups->name,

                ]
            ),201);

        } else {

            //Return respon message false if store user failed
            return $response->withJson(array(
                'status' => '401',
                'error' => true,
                'message' => 'Cannot retrieve user data'
            ),401);

        }

    }

    /**
    * Fetching user api key
    * @param String $user_id user id primary key in user table
    */
    public function getTokenById($request, $response) {
        //get user input
        $user_id = $request->getAttribute('id');

        //cek dataase and get api token
        $user = UsersModel::where('id', $user_id)
                                ->select('api_token')
                                ->first();

        //cek if !user
        if (isset($user)) {

            //give response message error false
            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'Success',
                'token' => $user->api_token
            ),201);

        } else {

            //give response message error true
            return $response->withJson(array(
                'status' => '401',
                'error' => true,
                'message' => 'Cannot retrieve user Token'
            ),401);

        }
    }

    /**
    * Validating user api key
    * If the api key is there in db, it is a valid key
    * @param String $api_key user api key
    * @return boolean
    */
    public function isValidToken($request, $response) {
        //get input
        $token = $request->getAttribute('token');

        //cek validation api token
        $user = UsersModel::where('api_token', $token)
                            ->select('id')
                            ->first();

        if (isset($user)) {
            //give response message error false
            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'API Token is Valid',
                'uid' => $user->id
            ),201);

        } else {
            //give response message error true
            return $response->withJson(array(
                'status' => '401',
                'error' => true,
                'message' => 'API Token invalid'
            ),401);

        }
    }

//===================================== fungsi penunjang =========================

    //Generate random md5 api token
    private function generateApiKey() {
        //return unique md5 random key
        return md5(uniqid(rand(), true));

    }


}
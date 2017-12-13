<?php

    namespace App\Controllers\Auth;
    use App\Controllers\Controller;
    use App\Models\UsersModel;
    use Respect\Validation\Validator as V;

class AuthController extends Controller {

    /**
    * Register new user
    * @param String
    */
    public function postSingUp($request, $response){

        try{

            $validation =  $this->validator->validate($request, [
                'name'          => V::notEmpty()->alpha(),
                'email'         => V::noWhiteSpace()->notEmpty()
                                    ->email()->emailAvailable(),
                'password'      => V::noWhiteSpace()->notEmpty(),
            ]);

            if($validation->failed()){
                return $response->withJson(array(
                        'errors' => $_SESSION['errors']
                ),401);
            }

            // Generating API key
            $api_token = $this->generateApiKey();

            UsersModel::create([
                'name'          => $request->getParam('name'),
                'email'         => $request->getParam('email'),
                'password'      => password_hash($request->getParam('password'),
                                    PASSWORD_BCRYPT, ['cost' => 10]),
                'api_token'     => $api_token
            ]);

            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'success'
            ),201);

        }catch(\Exception $e){

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
        $email      = $request->getParam('email');
        $password   = $request->getParam('password');

        $validation =  $this->validator->validate($request, [
            'email'         => V::noWhiteSpace()->notEmpty()->email(),
            'password'      => V::noWhiteSpace()->notEmpty(),
        ]);

        if($validation->failed()){
            return $response->withJson(array(
                    'errors' => $_SESSION['errors']
            ),401);
        }

        $user = UsersModel::where('email', $email)->first();

        if (!$user){
            if($user->email == null) {
                return $response->withJson(array(
                    'status' => '400',
                    'error' => true,
                    'message' => 'Login gagal, Periksa kembali email anda',
                ),400);
            }
        }

        if(password_verify($password, $user->password)){
            //diperlukan untuk test pada bagian reset password secara lokal
            //bisa dihapus ketika api di konsumsi dari client
            $_SESSION['user_id'] = $user->id;

             // Generating new API key
            $api_token = $this->generateApiKey();
            UsersModel::where('email', $email)->update(
                ['api_token' => $api_token]
            );

            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'Berhasil Login',
                'user_id' =>  $user->id,
                'user_name' => $user->name
            ),201);

            //return true;
        }

        //return false;
        return $response->withJson(array(
            'status' => '400',
            'error' => true,
            'message' => 'Login gagal, Periksa kembali password anda',
        ),400);


        // $auth = $this->attempt(

        //     $request->getParam('email'),
        //     $request->getParam('password')

        // );

        // if(!$auth){
        //     return $response->withJson(array(
        //         'error' => true,
        //         'messages' => 'Periksa email dan password kembali'

        //     ),401);
        // }


        // return $response->withJson(array(
        //     'status' => '201',
        //     'error' => false,
        //     'message' => 'Berhasil Login',
        //     'user_id' => $_SESSION['user_id'],
        //     'user_name' => $_SESSION['user_name']
        // ),201);

    }


    /**
    * Change password user
    * @param String $password old and new
    */
    public function postChangePassword($request, $response){

        $validation =  $this->validator->validate($request, [

            'password_old'      => V::noWhiteSpace()->notEmpty()
                                    ->matchesPassword($this->user()->password),
            'password_new'      => V::noWhiteSpace()->notEmpty(),

        ]);

        if($validation->failed()){

            return $response->withJson(array(
                'errors' => $_SESSION['errors']
            ),401);

        }

        $this->user()->setPassword($request->getParam('password_new'));
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
        $email = $request->getParam('email');
        $user = UsersModel::where('email', $email)
                            ->select('name', 'email', 'api_token')
                            ->first();

        if (isset($user)) {

            return $response->withJson($user);

        } else {

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

        $user_id = $request->getParam('id');
        $user = UsersModel::where('id', $user_id)
                                ->select('api_token')
                                ->first();

        if (isset($user)) {

            return $response->withJson($user);

        } else {

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

        $api_key = $request->getParam('api_token');
        $user = UsersModel::where('api_token', $api_key)
                            ->select('id')
                            ->first();

        if (isset($user)) {

            return $response->withJson($user);

        } else {

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
        $api_key = $request->getParam('api_token');
        $user = UsersModel::where('api_token', $api_key)
                            ->select('id')
                            ->first();

        if (isset($user)) {

            return $response->withJson(array(
                'status' => '201',
                'error' => false,
                'message' => 'API Token isValid'
            ),201);

        } else {

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
        return md5(uniqid(rand(), true));

    }

    public function user(){

        if (isset($_SESSION['user_id'])){

            return UsersModel::find($_SESSION['user_id']);

        }

    }

}
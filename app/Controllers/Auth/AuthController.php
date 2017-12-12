<?php

    namespace App\Controllers\Auth;
    use App\Controllers\Controller;
    use App\Models\UsersModel;
    use Respect\Validation\Validator as V;

    class AuthController extends Controller {

        public function postSingUp($request, $response){

            try{

                $validation =  $this->validator->validate($request, [
                    'name'          => V::notEmpty()->alpha(),
                    'email'         => V::noWhiteSpace()->notEmpty()->email()->emailAvailable(),
                    'password'      => V::noWhiteSpace()->notEmpty(),
                ]);

                if($validation->failed()){
                    return $response->withJson(array('errors' => $_SESSION['errors']),400);
                }


                UsersModel::create([
                    'name'          => $request->getParam('name'),
                    'email'         => $request->getParam('email'),
                    'password'      => password_hash($request->getParam('password'), PASSWORD_BCRYPT, ['cost' => 10])
                ]);

                return $response->withJson(array('status' => '200', 'message' => 'success'),200);

            }catch(\Exception $e){

                return $response->withJson(array('error' => $e->getMessage()),400);

            }


        }

        public function postSingIn($request, $response){

            $auth = $this->attempt(

                $request->getParam('email'),
                $request->getParam('password')

            );

            if(!$auth){
                return $response->withJson(array(
                    'errors' => 'Gagal Login',
                    'messages' => 'Periksa email dan password kembali'

                ),400);
            }

            return $response->withJson(array(
                'status' => '200',
                'message' => 'Berhasil Login',
                'user_id' => $_SESSION['user_id'],
                'user_name' => $_SESSION['user_name']
            ),200);

        }

        public function getSingOut($request, $response){

            $this->logout();
            return $response->withJson(array('status' => '200', 'message' => 'sing out success'),200);

        }

        public function postChangePassword($request, $response){

            $validation =  $this->validator->validate($request, [

                'password_old'      => V::noWhiteSpace()->notEmpty()->matchesPassword($this->user()->password),
                'password_new'      => V::noWhiteSpace()->notEmpty(),

            ]);

            if($validation->failed()){

                return $response->withJson(array('errors' => $_SESSION['errors']),400);

            }

            $this->user()->setPassword($request->getParam('password_new'));
            return $response->withJson(array('status' => '200', 'message' => 'change password success'),200);

        }


        //fungsi sebelum login coy biar makin gaul lah kita
        public function attempt ($email, $password) {

            $user = UsersModel::where('email', $email)->first();

            if (!$user){
                return false;
            }

            if(password_verify($password, $user->password)){
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                return true;
            }

            return false;

        }

        public function user(){

            if (isset($_SESSION['user_id'])){

                return UsersModel::find($_SESSION['user_id']);

            }

        }

        //fungsi logout
        public function logout (){

            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);

        }

    }
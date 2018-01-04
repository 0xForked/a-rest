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
    * @param String username, name, email, phone, password
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
                ),400);
            }

            // Generating API key
            $api_token = Controller::generateKey();
            //Get input email
            $email = $request->getParam('email');
            //Get input username
            $username = $request->getParam('username');
            //Get user full name
            $name = $request->getParam('full_name');
            //Get user phone
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

            //Create user-group if success create new user
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

                //Get user group by user id
                $user_group = UsersGroup::where('user_id', $user->id)->first();
                //Get group name by user group id
                $groups = GroupModel::where('id', $user_group->group_id)->first();
                //get user detail
                $user_detail = UsersDetail::where('user_id', $user->id)->first();

                //send mail
                $this->mailer->send('email_template.twig', ['user' => $user], 
                    function($message) use ($user){
            
                    $message->to($user->email);
                    $message->subject("Some App - Welcome Message");
                
                });

            }


            //Return respon message true, if store user !failed
            return $response->withJson(array(
                'status' => 201,
                'error' => false,
                'message' => 'success',
                'user' => [
                    'uid'       => $user->id,
                    'token'     => $user->api_token,
                    'group'     => $groups->name,
                ]
            ),201);

        }catch(\Exception $e){

            //error handle, if postSingUp failed to execute
            return $response->withJson(array(
                'error' => $e->getMessage()
            ),400);

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

        //Check validation
        if($validation->failed()){
            return $response->withJson(array(
                    'errors' => $_SESSION['errors']
            ),400);
        }

        //Check user
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

            // Generate new API key
            $api_token = Controller::generateKey();

            //Update new token
            $tokens = UsersModel::where('email', $email)->update(
                ['api_token' => $api_token]
            );

            if($tokens) {
                //get new user token
                $user_main = UsersModel::where('email', $email)->first();

                //Return respon message true, if user login !failed
                return $response->withJson(array(
                    'status'   => 200,
                    'error'    => false,
                    'message'  => 'Login Success',
                    'user' => [
                        'uid'       => $user->id,
                        'isActive'  => $user_main->active,
                        'token'     => $user_main->api_token,
                    ]
                ),200);
            }


        }

        //return false, if !password
        return $response->withJson(array(
            'status' => 400,
            'error' => true,
            'message' => 'Login failed, Please cek your password',
        ),400);

    }

}
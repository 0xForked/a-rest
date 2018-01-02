# A-rest Repo

### Library

1. <a href="https://github.com/illuminate/database">Eloquent</a> - ORM DB
2. <a href="https://github.com/twigphp/Twig">Twig</a> - Template
3. <a href="https://github.com/Respect/Validation">Respect Validation</a> - Validation
4. <a href="https://github.com/PHPMailer/PHPMailer">PHPMailer</a> - Mailler

<p align="center">
  <img src="https://raw.githubusercontent.com/aasumitro/a-rest/master/resources/assets/images/test.png" width="900">
</p>
<br>

### Config
    Import database
        |--- /database/asmith_rest.sql
    Database setting
        |--- /booting/app.php

    Email config
    Go to booting/app.php and change username and password as yours.
    if your want to make a custom body you can delete or comment on line 270,
    in AuthController and your can put your custom body email in folder resources/view/email.twig

### folder dan file
    root |
         |---App |--/Controllers
         |       |       |---/Controller.php
         |       |--/Mailer
         |       |       |---/Mailer.php
         |       |--/Middleware
         |       |       |---/Middleware.php
         |       |--/Models
         |       |       |---/Model.php
         |       |--/Validation
         |       |       |---/Validator.php
         |       |
         |       |-------routes.php
         |
         |---Booting
         |      |---app.php
         |
         |---Vendor
         |      |---composer
         |      |---container-interop
         |      |---doctrine
         |      |---illuminate
         |      |---nesbot
         |      |---nikic
         |      |---phpmailer
         |      |---pimple
         |      |---psr
         |      |---respect
         |      |---slim
         |      |---symfony
         |      |---twig
         |      |-----autoload.php
         |-----index.php
         |-----.htaccess


### Test Api

    Your can see on routes.php for more api links

    link test API sample data crud
       1. View/Navigation - base_url/example
       2. all data   - base_url/example/api/v1/datas
       3. data with id - base_url/example/api/v1/data/{id}
       4. add data - base_url/example/api/v1/create/data
            you need name or other of "data" as a parameter
       5. Update data - base_url/example/api/v1/update/data
            update data you need "data" and "id" as a parameter
       6. Delete data - base_url/example/api/v1/delete/data/{id}

    link test API Auth (Singin, Singup, Forgot Password. Change Password)
        1. singup - baseu_url/auth/singup
                need  "full_name", "phone", "username", "email", "password" as a parameter
        2. singin - base_url/auth/singin
                need "email", "password" as a parameter
        3. change password - base_url/auth/password/change
                need "old password" dan "new Password" as a parameter
        4. reset password - base_url/auth/password/reset
                need  "email" as a parameter and then you will get an email to reset your password

    auth account default admin
        1. email    :   mail@asmith.my.id
        2. password :   password
    auth account default member
        1. email    :   sidia@asmith.my.id
        2. password :   password

example implementation on android app with a-rest as a web service : 
- a-droid base version https://github.com/aasumitro/a-droid
- a-droid clean version https://github.com/aasumitro/a-droid-cc

# A-rest Repo
REST Service with [Slim Micro Framework](https://www.slimframework.com/)

<p align="center" style="margin-top:50px">
  <img src="https://raw.githubusercontent.com/aasumitro/a-rest/master/resources/assets/images/test.png" width="300">
  <img src="https://raw.githubusercontent.com/aasumitro/a-rest/master/resources/assets/images/database.png" width="300">
</p>
<br>

### Library

1. [Eloquent](https://github.com/illuminate/database) - ORM DB
2. [Twig](https://github.com/twigphp/Twig) - Template
3. [Respect Validation](https://github.com/Respect/Validation) - Validation
4. [PHPMailer](https://github.com/PHPMailer/PHPMailer) - Mailler

### Config
    Import database
        |--- /database/asmith_rest.sql
    App config
        |--- /booting/app.php
    Email
        Custom email body
            |--- /resources/view/email.twig

### Folder dan file
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


### Default account

Group | Email | Password
------------ |------------ | -------------
admin | mail@asmith.my.id | password
member | sidia@asmith.my.id | password

### Example implementation on android app :
- a-droid base version https://github.com/aasumitro/a-droid
- a-droid clean version (User auth[login/register] and data) https://github.com/aasumitro/a-droid-cc
- bajalang (Location Based Service) https://github.com/aasumitro/bajalang-cc


### TODO
- [X] Example Crud.
- [X] Example User Auth.
- [X] Example LBS.
- [ ] Example E-commerce.
- [ ] Clean up, code style and minor refactor.


### License
Copyright 2017-2018 A. A. Sumitro [LICENSE](https://github.com/aasumitro/a-rest/blob/master/LICENSE)
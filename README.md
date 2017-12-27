# a-rest

### Libs

1. <a href="https://github.com/illuminate/database">Eloquent</a> - ORM DB
2. <a href="https://github.com/twigphp/Twig">Twig</a> - Template
3. <a href="https://github.com/Respect/Validation">Validation</a> - Respect Validation
4. <a href="https://github.com/PHPMailer/PHPMailer">PHPMailer</a> - Send Mail

<p align="center">
  <img src="https://raw.githubusercontent.com/aasumitro/a-rest/master/resources/assets/images/test.png" width="900">
</p>
<br>

### Config
    Import database
        |--- /database/asmith_rest.sql
    Ganti setting database
        |--- /bootsrap/app.php

    email config
    buka bootsrap/app.php dan rubah username dan password dengan milik anda
    untuk membuat body secara kostum anda bisa menghapus atau menjadikan koment pada body default
    line 270 AuthController dan mengedit pada folder resources/view/email.twig

### folder dan file yang perlu diketahui
    root |
         |---App |--/Controllers
         |       |       |---/Controller.php
         |       |--/Mail
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
         |---Bootsrap
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

    -semua dimulai dari index.php -> awal mula aplikasi di jalankan  $app->run();
    -.htaccess
    -dilanjutkan ke bootsrap/app.php dari index.php selajutnya dari app.php ke routes.php dan ke semua class pada folder app

### Test Api

    untuk lebih lengapnya dapat dilihat pada file routes.php

    link test APIs data
       1.                         base_url/example
       2. lihat semua data -      base_url/example/api/v1/datas
       3. lihat data perid -      base_url/example/api/v1/data/{id}
       4. tambah data -           base_url/example/api/v1/create/data
            tambah data membutuhkan parameter "data" yang dapat
            diinput menggunakan post man sebagai tool uji coba
       5. Update data -           base_url/example/api/v1/update/data
            update data membutuhkan parameter "data" dan "id" yang dapat
            diinput menggunakan post man sebagai tool uji coba
       6. Delete data -           base_url/example/api/v1/delete/data/{id}

    link test APIs Auth (Singin & Singup)
        1. singup -             baseu_url/auth/singup
                membutuhkan parameter "full_name", "phone", "username", "emai", "password"
        2. singin -             base_url/auth/singin
                membutuhkan parameter "email", "password"
        3. change password -    base_url/auth/password/change
                membutuhkan parameter "old password" dan "new Password"
        4. reset password - base_url/auth/password/reset
                membutuhkan parameter "email" kemudian akan mendapatkan link reset pada email

    auth account default admin
        1. email    :   mail@asmith.my.id
        2. password :   password
    auth account default member
        1. email    :   sidia@asmith.my.id
        2. password :   password

contoh pengimplementasian : 
- a-droid (android app with a-rest as a web service) https://github.com/aasumitro/a-droid

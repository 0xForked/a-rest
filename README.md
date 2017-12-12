# asmith-rest

### Libs

1. <a href="https://github.com/illuminate/database">Eloquent</a> - ORM DB
2. <a href="https://github.com/twigphp/Twig">Twig</a> - Template
2. <a href="https://github.com/Respect/Validation">Validation</a> - Respect Validation

### Config
    Import database
        |--- /database/asmith_rest.sql
    Ganti setting database ke database yang anda gunakan
        |--- /bootsrap/app.php

### folder dan file yang perlu diketahui
    root |
         |---App |--/Controllers
         |       |       |---/Controller.php   
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
    -dilanjutkan ke bootsrap/app.php dari index.php selajutnya dari app.php ke routes.php dan ke folder app

### Test Api

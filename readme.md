## Install

- `git clone https://github.com/viandwi24/vilacore`
- `cd vilacore`
- `composer update`
- copy .env.example to .env
- edit .env configuration
- `php artisan migrate`
- `php artisan serve` and open `localhost:8000/v-admin`


## Plugin

### Mendaftarkan Plugin
Plugin ada di folder `App/Core/`, lalu setiap plugin harus didaftarkan pada `App/Core/list.json` dan isinya berikut :
#### load
Plugin yang ingin didaftarkan harus di tulis dalam 'load', mendaftarkan plugin di load menggunakan nama package plugin
#### enable
Enable adalah plugin yang akan diaktifkan, sama seperti load untuk mendaftarkanya cukup tulis nama package

### Membuat Plugin Sederhana
Sebernanya untuk membuat plugin sudah di contohkan di plugin bernama 'example', mari kita bahas :
- tentukan nama package untuk plugin yang akan dibuat, misalnya disini memakai `tes`
- buat folder dan file di `App/Core/` sesuai dengan nama package yang telah ditentukan tadi
    * [Buat Folder] App/Core/tes
    * [Buat File] App/Core/tes/tes.php
    * [Buat File] App/Core/tes/info.json
- lalu isi dari file `tes.php` dan `info.json` adalah sebagai berikut :
    * #### App/Core/tes/tes.php
    ```
    <?php
    namespace App\Core;
    use App\Core\BaseCore as Core;

    class example implements Core {

        public function map()
        {
        }

        public function register()
        {
        }

        public function boot()
        {
            // membuat menu di sidebar admin
            customMenu()->add([
                'type' => 'normal',
                'name' => 'Example Normal',
                'icon' => 'fa-feather',
                'link' => route('example.index')
            ]);
        }

        public function load()
        {
        }
    }
    ```
    * #### App/Core/tes/info.json
    ```
    {
        "name": "Examples",
        "version": "1.0.0",
        "description": "Examples plugin.",
        "author": "viandwi24",
        "email": "fiandwi0424@gmail.com",
        "settingPage": "setting"
    }
    ```





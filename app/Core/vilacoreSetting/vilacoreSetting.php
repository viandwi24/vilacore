<?php
namespace App\Core;
use App\Core\BaseCore as Core;

class vilacoreSetting implements Core {
    public function register()
    {
    }

    public function boot()
    {
        customMenu()->add([
            "type" => "setting-treeview",
            "name" => "Vilacore",
            "icon" => "fa-cogs",
            "menu" => [
                ["name" => "Env", "icon" => "file-invoice", "link" => route('vilacoreSetting.env')],
                // ["name" => "Kelola Akun Admin", "icon" => "fa-users", "link" => route('vilacoreAuth.kelola')],
            ]
        ]);
    }
    
    public function map()
    {
        customRoute()->add(__DIR__ . '/routes.php');
    }    

    public function load($request, $next)
    {
    } 

    public function terminate($request)
    {
    }
}        
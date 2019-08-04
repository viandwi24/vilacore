<?php
namespace App\Core;
use App\Core\BaseCore as Core;

class vilacoreAuth implements Core {
    public function register()
    {
    }

    public function boot()
    {
        customMenu()->add([
            "type" => "setting-treeview",
            "name" => "Akun",
            "icon" => "fa-users-cog",
            "menu" => [
                ["name" => "Profil Saya", "icon" => "fa-address-card", "link" => route('vilacoreAuth.index')],
                // ["name" => "Kelola Akun Admin", "icon" => "fa-users", "link" => route('vilacoreAuth.kelola')],
            ]
        ]);
    }
    
    public function map()
    {
        customRoute()->add(__DIR__ . '/routes.php', ['web', 'auth']);
    }    

    public function load($request, $next)
    {
    } 

    public function terminate($request)
    {
    }
}
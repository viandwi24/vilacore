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
                ["name" => "Env", "icon" => "fa-file-invoice", "link" => route('vilacoreSetting.env')],
                ["name" => "Artisan", "icon" => "fa-terminal", "link" => route('vilacoreSetting.artisan')],
                // ["name" => "Kelola Akun Admin", "icon" => "fa-users", "link" => route('vilacoreAuth.kelola')],
            ]
        ]);

        admin()->addDashboardInfoBox([
            'title' => 'App Env',
            'icon' => 'fa-wrench',
            'icon-box' => (env("APP_ENV", "production") == 'local' ? 'bg-danger' : 'bg-warning'),
            'value' => ucfirst(env("APP_ENV", "production"))
        ]);
    }
    
    public function map()
    {
        customRoute()->add(__DIR__ . '/routes.php', []);
    }    

    public function load($request, $next)
    {
    } 

    public function terminate($request)
    {
    }
}        
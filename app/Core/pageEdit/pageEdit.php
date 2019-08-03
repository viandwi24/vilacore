<?php
namespace App\Core;

use App\Core\BaseCore as Core;

class pageEdit implements Core {
    public function register()
    {
    }

    public function boot()
    {
        customMenu()->add([
            'type' => 'header',
            'name' => 'Page Edit',
        ]);
        customMenu()->add([
            'type' => 'normal',
            'name' => 'Plugin Page Editor',
            'icon' => 'fa-pen-square',
            'link' => route('pageEdit.index')
        ]);
    }
    
    public function map()
    {
        customRoute()->add(__DIR__ . '/routes.php');
    } 

    public function load()
    {
    }
}

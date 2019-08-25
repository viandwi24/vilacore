<?php
namespace App\Core;
use App\Core\BaseCore as Core;

class homepage implements Core {
    public function register()
    {
    }

    public function boot()
    {
        // sidebar menu
        customMenu()->add([
            'type' => 'header',
            'name' => 'Simple Homepage'
        ]);
        $route = ( \Route::has('pageEdit.explore.edit') ? route('pageEdit.explore.edit', ['package' => 'homepage', 'path' => '/views/index.blade.php']) : route('homepage.error') );
        customMenu()->add([
            'type' => 'normal',
            'name' => 'Edit Homepage',
            'icon' => 'fa-edit',
            'link' => $route
        ]);

        // dashboard admin infobox
        $plugin_count = count(plugin()->getAll(true));
        admin()->addDashboardInfoBox([
            'title' => 'Simple Homepage',
            'icon' => 'fa-home',
            'icon-box' => 'bg-info',
            'value' => '<a target="_blank" href="'.url('/').'">Lihat home</a>'
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
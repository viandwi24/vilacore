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
        
        // plugin widget
        $plugin_count = count(plugin()->getAll(true));
        admin()->addDashboardInfoBox([
            'title' => 'Plugin Aktif',
            'icon' => 'fa-plug',
            'icon-box' => 'bg-info',
            'value' => $plugin_count
        ]);
        
        admin()->addDashboardWidget("pageEdit::views.widget");
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
<?php

namespace App\Core;

use App\Core\BaseCore as Core;

class example implements Core {

    public function map()
    {
        // add routes
        $this->addRoute();
    }

    public function register()
    {
    }

    public function boot()
    {
        // add panel admin menu
        $this->addMenu();
    }

    public function load()
    {
    }




    /**
     * Add Menu To Sidebar Admin
     */
    private function addMenu()
    {
        customMenu()->add([
            'type' => 'header',
            'name' => 'EXAMPLE HEADER ',
        ]);
        customMenu()->add([
            'type' => 'treeview',
            'name' => 'Example Treeview',
            'icon' => 'fa-feather-alt',
            'menu' => [
                ['name' => 'Example Child', 'icon' => 'fa-chevron-right', 'link' => route('example.blank')]
            ]
        ]);

        customMenu()->add([
            'type' => 'normal',
            'name' => 'Example Normal',
            'icon' => 'fa-feather',
            'link' => route('example.tes')
        ]);
    }


    /**
     * Add Custom Routes
     */
    private function addRoute()
    {
        customRoute()->add(__DIR__ . '/routes.php');

    }
}
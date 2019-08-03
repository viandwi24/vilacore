<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class VilacoreServiceProvider extends ServiceProvider
{
    private $coreLoad = [];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // load helper
        require_once app_path() . '/Helpers/load.php';

        // register plugin
        $plugins = $this->getCoreAll(true);
        foreach ($plugins as $plugin) {
            // include
            plugin()->setActive($plugin);
            require_once $this->corePath($plugin) . '/' . $plugin . '.php';

            // register
            $class = "\App\Core\\" . $plugin;
            $this->coreLoad[$plugin] = new $class;
            $this->coreLoad[$plugin]->register();
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {           
        // blade custom
        $this->customBlade();
        // $this->stack();


        $this->app->booted(function() {
            // boot
            $plugins = $this->getCoreAll(true);
            foreach ($plugins as $plugin) {
                plugin()->setActive($plugin);
                // views register
                \View::addNamespace($plugin, $this->corePath($plugin));

                // boot
                $this->coreLoad[$plugin]->boot();
            }

            plugin()->saveCoreLoad($this->coreLoad);
        });
    }


    public function stack()
    {
        // $currentPath= Route::getFacadeRoot();
        // dd(  $currentPath );
    }

    /**
     * Get All Plugin Core
     */
    private function getCoreAll($enableOnly = false)
    {
        $list = file_get_contents(app_path('Core/list.json'));
        $list = json_decode($list, true);

        return $enableOnly ? $list['enable'] : $list['load'];
    }

    /** */
    private function corePath($core)
    {
        return app_path('Core/' . $core);
    }

    /** Blade Custom */
    private function customBlade()
    {
    }
}

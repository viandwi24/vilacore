<?php
namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
class CustomRoute extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();

        // dd( $this->app->request->getRequestUri() );
    }
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $plugins = $this->getCoreAll(true);
        
        foreach ($plugins as $plugin) {
            // include
            plugin()->setActive($plugin);
            require_once $this->corePath($plugin) . '/' . $plugin . '.php';

            // register
            $class = "\App\Core\\" . $plugin;
            $core = new $class;
            $core->map();
        }
    }

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
}
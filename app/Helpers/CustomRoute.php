<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class CustomRoute {
    private static $routePlugin = [];

    public static function add($group, $middleware = ["web"])
    {
        if (!is_file($group)) return false;
        $plugin_name = plugin()->getActive();
        Route::middleware($middleware)
            ->namespace('App\\Core\\' . $plugin_name)
            ->as($plugin_name.'.')
            ->group($group);
        
        self::$routePlugin[$plugin_name][] = $group;
    }




    public function getRoutePlugin($package)
    {
        $tes = Route::getRoutes();
        $route = [];
        foreach($tes as $item)
        {
            if (isset($item->action['as']))
            {
                $as = $item->action['as'];
                $tes = explode('.', $as);
                
                if ($as == '.'.$package) {
                } elseif (count($tes) > 1 && $tes[0] == $package) {
                } else {
                    continue;
                }
                $item_info = $item->action;
                $item_info['uri'] = $item->uri;
                $item_info['methods'] = $item->methods;
                // $item_info['file'] = $group;
                $route[] = $item_info;
            }
        }
        
        return (object) $route;
    }

    public function getRouteFilePlugin($package)
    {
        return self::$routePlugin[$package];
    }
}
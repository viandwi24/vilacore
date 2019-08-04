<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;

class CheckCoreRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $coreLoad = plugin()->getCoreLoad();

        // load
        $plugins = plugin()->getAll(true);
        foreach ($plugins as $plugin) {
            // set active
            plugin()->setActive($plugin);
            
            // save core load
            plugin()->saveCoreLoad($coreLoad);
            
            // load
            $state = $coreLoad[$plugin]->load($this->getRequest($request), $next);
            if (!empty($state)) return $state;
        }
        
        // save core load
        plugin()->saveCoreLoad($coreLoad);

        return $next($request);
    }


    public function terminate($request, $response)
    {
        $coreLoad = plugin()->getCoreLoad();

        // terminate
        $plugins = plugin()->getAll(true);
        foreach ($plugins as $plugin) {
            plugin()->setActive($plugin);
            // terminate
            try {
                $state = $coreLoad[$plugin]->terminate($this->getRequest($request));
            } catch (\Throwable $th) {
                return false;
            }
        }
    }

    private function getRequest($request)
    {
        $route = Route::getRoutes()->match($request);
        $request->route = $route;
        return $request;
    }
}

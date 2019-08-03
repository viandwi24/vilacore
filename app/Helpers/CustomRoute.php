<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class CustomRoute {

    public static function add($group)
    {
        Route::middleware('web')
            ->namespace('App\\Core\\' . plugin()->getActive())
            ->as(plugin()->getActive().'.')
            ->group($group);
    }
}
<?php

namespace App\Core;

use Illuminate\Support\Facades\Route;
use App\Core\BaseCore as Core;

class notifme implements Core {
    public function map()
    {
    }

    public function register()
    {
    }

    public function boot()
    {
    }

    public function load($request, $next)
    {
        echo '<script>alert("This is alert in-load!! notifme:load ");</script>';
    }

    public function terminate($request)
    {
    }
}
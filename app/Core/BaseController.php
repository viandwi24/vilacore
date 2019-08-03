<?php

namespace App\Core;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        $package = get_called_class();
        $package = explode('\\', $package);
        plugin()->setActive($package[2]);
    }
}

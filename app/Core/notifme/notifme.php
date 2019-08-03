<?php

namespace App\Core;

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

    public function load()
    {
        echo '
        <script>alert("This is alert!! .:notifme:. ");</script>';
    }
}
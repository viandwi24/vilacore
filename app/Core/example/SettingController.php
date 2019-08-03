<?php

namespace App\Core\example;

use App\Core\BaseController;
use Illuminate\Http\Request;

class SettingController extends BaseController
{

    public function index()
    {
        return view('example::setting');
    }
}

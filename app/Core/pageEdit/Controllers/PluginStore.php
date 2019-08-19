<?php

namespace App\Core\pageEdit\Controllers;

use App\Core\BaseController;
use Illuminate\Http\Request;

class PluginStore extends BaseController
{
    public function index()
    {
        $json = [];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://raw.githubusercontent.com/viandwi24/vilacore-plugin/master/list.json');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // $result = curl_exec($ch);
        // curl_close($ch);
        // $json = json_decode($result);

        // dd($json);

        return view('pageEdit::views.store', compact('json'));
    }


    private function tes()
    {
        $json = [
            [
                "name" => "Page Edit",
                "package" => "pageEdit",
                "description" => "Edit Plugin Lain Secara GUI.",
                "version" => "1.2.0",
                "required" => "1.0.7",
                "author" => "viandwi24",
                "email" => "fiandwi0424@gmail.com",
                "settingPage" => "about"
            ],
            [
                "name" => "Auth Setting for Admin",
                "package" => "vilacoreAuth",
                "description" => "Menambahkan menu pengaturan dan profil autentikasi di halaman Admin.",
                "version" => "1.0.0",
                "required" => "1.0.7",
                "author" => "viandwi24",
                "email" => "fiandwi0424@gmail.com"
            ]
        ];

        return json_encode($json);
    }
}
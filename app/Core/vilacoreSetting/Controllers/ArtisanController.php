<?php

namespace App\Core\vilacoreSetting\Controllers;

use App\Core\BaseController;
use Illuminate\Http\Request;
use DotenvEditor;
use Artisan;

class ArtisanController extends BaseController
{
    public function index()
    {
        return view("vilacoreSetting::views.artisan");
    }
    
    public function run(Request $request)
    {
        // $command = substr($request->command, 8, strlen($request->command));
        // $run = Artisan::call($command);
        return response()->json([
            'result' => $this->runCommand($request->command)
        ]);
    }

    private function runCommand($command)
    {
        // $cmd = base_path("artisan $command 2>&1");

        // $handler = popen($cmd, 'r');
        // $output = '';
        // while (!feof($handler)) {
        //     $output .= fgets($handler);
        // }
        // $output = trim($output);
        // $status = pclose($handler);

        $output = shell_exec("cd ../ && php artisan $command");
        return $output;
    }
}
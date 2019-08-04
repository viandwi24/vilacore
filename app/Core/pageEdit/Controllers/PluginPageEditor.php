<?php

namespace App\Core\pageEdit\Controllers;

use App\Core\BaseController;
use Illuminate\Http\Request;

class PluginPageEditor extends BaseController
{
    public function index()
    {
        return view('pageEdit::views.index');
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip'
        ]);


        $zip = new \ZipArchive;
        $res = $zip->open($request->file('file'));
        if ($res === TRUE) {
            mkdir(app_path('Core/tmp'), 0755);
            $zip->extractTo(app_path('Core/tmp'));
            $zip->close();
            //berhasil

            //cek info
            $path = app_path('Core/tmp/info.json');
            $info = file_get_contents($path);
            $info = json_decode($info, true);
            $package_name = $info['package'];
            rename(app_path('Core/tmp'), app_path('Core/'.$package_name));
            

            // add to list.json
            $plugins = file_get_contents(app_path('Core/list.json'));
            $plugins = json_decode($plugins, true);
            array_push($plugins['load'], $package_name);
            $plugins = json_encode($plugins);
            file_put_contents(app_path('Core/list.json'), $plugins);
        }

        return redirect()->back();
    }
    
    public function export($package)
    {
        if (!plugin()->check($package)) abort(404);
        
        $path = app_path('Core/' . $package);
        $path = explode('/', $path);
        $path = implode('/', $path);
        $package_info = plugin()->getInfo($package);
        
        $zip_file = $package.'-'.$package_info->version.'.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                $relativePath = '/' . substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }

    public function delete($package)
    {
        if (!plugin()->check($package)) abort(404);
        $path_del = app_path('Core/' . $package);
        $path_del = explode('/', $path_del);
        $path_del = implode('/', $path_del);

        // del folder plugin
        $this->rrmdir($path_del);

        // del from list
        $plugins = file_get_contents(app_path('Core/list.json'));
        $plugins = json_decode($plugins, true);
        
        $search = array_search($package, $plugins['enable']);
        if (!$search === false) unset($plugins['enable'][$search]);
        
        $search = array_search($package, $plugins['load']);
        if (!$search === false) unset($plugins['load'][$search]);
        
        $search = array_search($package, $plugins['hide']);
        if (!$search === false) unset($plugins['hide'][$search]);
        
        $plugins = json_encode($plugins);
        file_put_contents(app_path('Core/list.json'), $plugins);


        return redirect()->back();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'package' => 'required',
            'version' => 'required',
            'required' => 'required',
            'description' => 'required',
            'author' => 'required',
            'email' => 'required|email',
        ]);

        mkdir(app_path('Core/' . $request->package), 0755);
        
        // info.json
        $info = '{ "name": "'.$request->name.'", "package": "'.$request->package.'", "description": "'.$request->description.'", "version": "'.$request->version.'", "required": "'.$request->required.'", "author": "'.$request->author.'", "email": "'.$request->email.'" }';
        file_put_contents(app_path('Core/' . $request->package.'/info.json'), $info);

        // add to list.json
        $plugins = file_get_contents(app_path('Core/list.json'));
        $plugins = json_decode($plugins, true);
        array_push($plugins['load'], $request->package);
        $plugins = json_encode($plugins);
        file_put_contents(app_path('Core/list.json'), $plugins);

        // add to package\package.php
        $index_file = <<<EOT
<?php
namespace App\Core;
use App\Core\BaseCore as Core;

class {package} implements Core {
    public function register()
    {
    }

    public function boot()
    {
    }
    
    public function map()
    {
    }    

    public function load({request}, {next})
    {
    } 

    public function terminate({request})
    {
    }
}        
EOT;
        $index_file = str_replace('{package}', $request->package, $index_file);
        $index_file = str_replace('{request}', '$request', $index_file);
        $index_file = str_replace('{next}', '$next', $index_file);
        file_put_contents(app_path('Core/' . $request->package.'/'.$request->package.'.php'), $index_file);

        return redirect()->back();
    }

    public function explore($package)
    {
        if (!plugin()->check($package)) abort(404);

        $path = app_path('Core/' . $package);
        $current_path = '/';
        $prev_path = '/';
        if (isset($_GET['path']))
        {
            $pg = explode('/', $_GET['path']);
            $pg = implode('/', $pg);
            $current_path = $pg . '/';
            $path = $path . $pg;


            // prev
            $pg = explode('/', $_GET['path']);
            unset($pg[count($pg)-1]);
            $prev_path = implode('/', $pg);
        }

        if (!is_dir($path)) return redirect()->route('pageEdit.explore', ['package' => $package]);

        $files = $this->getListDir($path);

        return view('pageEdit::views.explore', compact('package', 'path', 'files', 'current_path', 'prev_path'));
    }

    public function explore_create(Request $request, $package)
    {
        if (!plugin()->check($package)) abort(404);
        $request->validate([
            'path' => 'required',
            'name' => 'required',
        ]);

        $path = app_path('Core/' . $package) . $request->path;
        $path = explode('/', $path);
        $path = implode('/', $path);
        // return $request->all();

        if ($request->type == 'folder')
        {
            mkdir( $path . $request->name, 0755 );
            return redirect()->back();
        } else  {
            file_put_contents( $path . $request->name, '');
            return redirect()->back();
        }
    }

    private function rrmdir($dir) {
        if (is_dir($dir)) {
          $objects = scandir($dir);
          foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
              if (filetype($dir."/".$object) == "dir") 
                 $this->rrmdir($dir."/".$object); 
              else unlink   ($dir."/".$object);
            }
          }
          reset($objects);
          rmdir($dir);
        }
       }

    public function explore_delete(Request $request, $package)
    {
        if (!plugin()->check($package)) abort(404);
        $request->validate([
            'path' => 'required',
        ]);

        $path_del = app_path('Core/' . $package) . $request->path;
        $path_del = explode('/', $path_del);
        $path_del = implode('/', $path_del);
        
        if (is_dir($path_del)) {
            $this->rrmdir($path_del);
        } else {
            if (is_file($path_del)) unlink($path_del);
        }

        return redirect()->back();
    }

    public function explore_edit($package)
    {
        if (!plugin()->check($package)) abort(404);
        $path = app_path('Core/' . $package) . $_GET['path'];
        $path = explode('/', $path);
        $path = implode('/', $path);
        $file = file_get_contents($path);
        $file_info = (object) pathinfo($path);


        return view('pageEdit::views.edit', compact('file', 'path', 'file_info', 'package'));
    }

    public function explore_edit_save(Request $request)
    {
        $request->validate([
            'path' => 'required',
            'editor' => 'required',
        ]);

        $path = $request->path;
        $file = $request->editor;
        $prev = $request->prev_url;

        if (is_file($path)) {
            file_put_contents($path, $file);
        }

        return redirect()->back();
    }

    private function getListDir($path)
    {
        $files = array_diff(scandir($path), array('..', '.'));

        $file = [];
        $folder = [];
        foreach($files as $item)
        {
            $f = $path . '/' . $item;

            if (is_dir($path . '/' . $item)) {
                array_push($folder, [
                    'type' => 'folder',
                    'item' => $item,
                    'info' => pathinfo($f),
                    'modified' => date ("F d Y H:i:s.", filemtime($f)),
                ]);
            } else {
                array_push($file, [
                    'type' => 'file',
                    'item' => $item,
                    'info' => pathinfo($f),
                    'modified' => date ("F d Y H:i:s.", filemtime($f)),
                ]);
            }
        }

        // dd(array_merge($folder, $file));
        return json_decode(json_encode(array_merge($folder, $file)));
    }
}
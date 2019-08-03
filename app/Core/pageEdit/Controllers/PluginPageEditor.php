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

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'package' => 'required',
            'version' => 'required',
            'description' => 'required',
            'author' => 'required',
        ]);

        mkdir(app_path('Core/' . $request->package), 0755);
        
        // info.json
        $info = '{ "name": "'.$request->name.'", "description": "'.$request->description.'", "version": "'.$request->version.'", "author": "'.$request->author.'" }';
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
}        
EOT;
        $index_file = str_replace('{package}', $request->package, $index_file);
        file_put_contents(app_path('Core/' . $request->package.'/'.$request->package.'.php'), $index_file);
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
        $path = app_path('Core/' . $package) . $_GET['path'];
        $path = explode('/', $path);
        $path = implode('/', $path);
        $file = file_get_contents($path);
        $file_info = (object) pathinfo($path);


        return view('pageEdit::views.edit', compact('file', 'path', 'file_info'));
    }

    public function explore_edit_save(Request $request)
    {
        $request->validate([
            'path' => 'required',
            'editor' => 'required',
            'prev_url' => 'required',
        ]);

        $path = $request->path;
        $file = $request->editor;
        $prev = $request->prev_url;

        if (is_file($path)) {
            file_put_contents($path, $file);
        }

        return redirect($prev);
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

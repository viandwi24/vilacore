<?php

Route::get('/', function () {
    return view('welcome');
});



/**
 * ADMIN ROUTES
 */
Route::group([
    'prefix' => env('ADMIN_URL_PREFIX', 'admin'),
    'as' => 'admin.',
    'middleware' => 'auth'
], function(){
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    $alat_enable = env('PLUGIN_SETTING_SHOW', true);
    if ($alat_enable) {
        Route::get('/alat', function () {
            return view('admin.alat');
        })->name('alat');
        Route::get('/alat/d/{package}', function ($package) {
            if (!plugin()->check($package, true)) abort(404);
            $plugin = plugin()->getInfo($package);
            return view('admin.deskripsi', compact('plugin'));
        })->name('alat.deskripsi');
        Route::get('/alat/toggle/{package}', function ($package) {
            if (!plugin()->check($package, true)) abort(404);
            $last_package = plugin()->getInfo($package);
            if (plugin()->toggle($package)) {
                return redirect()->back()->with(['alert' => ['type' => ($last_package->status ? 'error' : 'success'), 'text' => $package . ' telah di aktifkan.']]);
            } else {
                return redirect()->back()->with(['alert' => ['type' => ($last_package->status ? 'error' : 'success'), 'text' => $package . ' telah di nonaktifkan.']]);
            }
        })->name('alat.toggle');
        Route::get('/alat/prioritas', function(){
            return view('admin.alat_prioritas');
        })->name('prioritas');
        Route::post('/alat/prioritas', function(){
            $request = app()->request;
            $pluginNew = [];
            foreach(json_decode($request->json) as $item)
            {
                $pluginNew[] = $item->package;
            }

            $plugins = file_get_contents(app_path('Core/list.json'));
            $plugins = json_decode($plugins, true);
            $plugins['enable'] = $pluginNew;
            $plugins = json_encode($plugins);
            file_put_contents(app_path('Core/list.json'), $plugins);

            return redirect()->back()->with(['alert' => ['type' => 'success', 'text' => 'Berhasil menyimpan perubahan.']]);
        })->name('prioritas.save');
    }
});

/** AUTH */
Route::group([
    'prefix' => env('ADMIN_URL_PREFIX', 'admin'),
    'as' => 'admin.',
], function(){
    Auth::routes();
});


/** OTHER */
Route::get('/home', function(){ return redirect()->route('admin.dashboard'); })->name('home');

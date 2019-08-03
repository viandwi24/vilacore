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
    
    Route::get('/alat', function () {
        return view('admin.alat');
    })->name('alat');

    Route::get('/alat/toggle/{package}', function ($package) {
        if (plugin()->toggle($package)) { }
        return redirect()->back();
    })->name('alat.toggle');
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

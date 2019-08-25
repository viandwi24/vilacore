<?php
Route::group([], function(){
    Route::get('/', function(){
        return view('homepage::views.index');
    });
});


Route::group([
    'prefix' => plugin()->getAdminRoutePrefix(),
    'middleware' => 'auth'
], function(){
    Route::get('/error', function(){
        return view('homepage::views.no-pageEdit');
    })->name('error');
});
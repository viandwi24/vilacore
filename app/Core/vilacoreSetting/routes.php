<?php

Route::group([
    "prefix" => plugin()->getAdminRoutePrefix(),
    "middleware" => ["web", "auth"]
], function(){
    Route::get('/env', 'Controllers\EnvController@index')->name('env');
    Route::patch('/env', 'Controllers\EnvController@save')->name('env.save');
    Route::delete('/env', 'Controllers\EnvController@delete')->name('env.delete');
    Route::post('/env/create', 'Controllers\EnvController@create')->name('env.create');
    
    Route::get('/env/backup', 'Controllers\EnvController@backup')->name('env.backup');


    Route::get('/artisan', 'Controllers\ArtisanController@index')->name('artisan');
    Route::post('/artisan', 'Controllers\ArtisanController@run')->name('artisan.run');
});


// Route::group([
//     "prefix" => plugin()->getAdminRoutePrefix(),
// ], function(){
//     Route::post('/artisan/run', '\Emir\Webartisan\WebartisanController@actionRpc')->name('artisan.run');
// });
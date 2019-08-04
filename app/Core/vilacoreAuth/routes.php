<?php

Route::group([
    "prefix" => plugin()->getAdminRoutePrefix()
], function(){
    Route::get('/', 'Controllers\MyProfileController@index')->name('index');

    Route::get('/kelola', 'Controllers\MyProfileController@kelola')->name('kelola');
    Route::post('/change', 'Controllers\MyProfileController@change')->name('change');
    Route::post('/change_password', 'Controllers\MyProfileController@change_password')->name('change.password');
});
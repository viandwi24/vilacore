<?php

Route::group([
    "prefix" => plugin()->getAdminRoutePrefix()
], function(){
    Route::get('/env', 'Controllers\EnvController@index')->name('env');
});
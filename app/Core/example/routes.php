<?php

Route::group([
    'prefix' => plugin()->getAdminRoutePrefix()
], function(){
    Route::get('/tes', 'SettingController@index')->name('tes');
    Route::get('/blank', 'SettingController@index')->name('blank');



    /** SETTING PAGE */
    Route::get('/setting', 'SettingController@index')->name('setting');
});
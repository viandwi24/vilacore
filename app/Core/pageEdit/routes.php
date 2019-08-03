<?php

Route::group([
    'prefix' => plugin()->getAdminRoutePrefix(),
    'middleware' => 'auth'
], function(){
    Route::get('/', 'Controllers\PluginPageEditor@index')->name('index');
    Route::post('/create', 'Controllers\PluginPageEditor@create')->name('create');
    Route::post('/delete/{package}', 'Controllers\PluginPageEditor@delete')->name('delete');
    Route::get('/{package}/explore', 'Controllers\PluginPageEditor@explore')->name('explore');
    Route::get('/{package}/export', 'Controllers\PluginPageEditor@export')->name('export');
    Route::post('/import', 'Controllers\PluginPageEditor@import')->name('import');
    Route::post('/{package}/explore/create', 'Controllers\PluginPageEditor@explore_create')->name('explore.create');
    Route::post('/{package}/explore/delete', 'Controllers\PluginPageEditor@explore_delete')->name('explore.delete');
    Route::get('/{package}/explore/edit', 'Controllers\PluginPageEditor@explore_edit')->name('explore.edit');
    Route::post('/{package}/explore/edit', 'Controllers\PluginPageEditor@explore_edit_save')->name('explore.edit.save');


    /** SETTING */
    Route::get('/about', function(){
        return view('pageEdit::views.about');
    })->name('about');
});
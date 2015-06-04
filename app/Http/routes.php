<?php

Route::get('/', 'IndexController@index');

Route::get('ziplookup', ['as' => 'ziplookup', 'uses' => 'IndexController@index']);
Route::post('ziplookup', ['as' => 'ziplookup', 'uses' => 'IndexController@postZipResult']);

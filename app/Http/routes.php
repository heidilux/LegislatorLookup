<?php

Route::get('/', 'IndexController@index');

Route::get('ziplookup', ['as' => 'ziplookup', 'uses' => 'IndexController@index']);
Route::post('ziplookup', ['as' => 'ziplookup', 'uses' => 'IndexController@postZipResult']);

Route::get('bills/{id}', ['as' => 'sponsored-bills', 'uses' => 'IndexController@showSponsoredBills']);

Route::get('{method}/{filter}/{query}/{fields?}', ['as' => 'apiLookup', 'uses' => 'IndexController@apiLookup']);
<?php

Route::get('/', 'IndexController@index');

Route::get('bills/{id}', ['as' => 'sponsored-bills', 'uses' => 'IndexController@showSponsoredBills']);
Route::get('committees/{id}', ['as' => 'committees', 'uses' => 'IndexController@showCommittees']);

Route::get('{method}/{filter}/{query}/{fields?}', ['as' => 'apiLookup', 'uses' => 'IndexController@apiLookup']);
<?php

Route::get('/', 'IndexController@index');

Route::get('legislator/{id}', ['as' => 'legislator', 'uses' => 'LegislatorController@index']);
Route::get('bills/{id}', ['as' => 'sponsored-bills', 'uses' => 'BillsController@index']);
Route::get('committees/{id}', ['as' => 'committees', 'uses' => 'CommitteesController@index']);

Route::get('{method}/{filter}/{query}/{fields?}', ['as' => 'apiLookup', 'uses' => 'IndexController@apiLookup']);
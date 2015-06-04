<?php

Route::get('/', 'IndexController@index');

Route::get('api/{zip}', ['uses' => 'IndexController@showResult']);

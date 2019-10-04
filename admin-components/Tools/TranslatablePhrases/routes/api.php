<?php

use Illuminate\Support\Facades\Route;

\Route::group(['prefix' => 'tool/translatable-phrases'], function () {
    Route::get('/{locale?}', 'TranslatablePhrasesController@index')->where(['locale' => '[a-z]{2}']);
    Route::post('/parse', 'TranslatablePhrasesController@parse');
    Route::post('/save', 'TranslatablePhrasesController@save');
});

<?php

if (\App::runningUnitTests()) {
    $locale = \App::getLocale();
} else {
    $locale = request()->segment(1);
}

if (strlen($locale) !== 2) {
    $locale = '';
} else {
    request()->merge([
        'locale' => $locale
    ]);
}

Route::get('', 'PageController@index');

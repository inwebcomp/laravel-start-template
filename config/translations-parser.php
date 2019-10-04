<?php

return [
    // Locales to save phrases
    'locales' => [
        'ru',
        'ro',
    ],

    // Directories in which phrases are searched
    'directories' => [
        base_path('app'),
        resource_path('views'),
    ],

    // Excluded directories or files
    'excluded' => [
        'Admin'
    ],

    // Where is your folder with translations
    'lang_files_directory' => resource_path('lang')
];

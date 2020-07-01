<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Library  Name
   |--------------------------------------------------------------------------
   |
   | This value is the name of your application. This value is used when the
   | framework needs to place the application's name in a notification or
   | any other location as required by the application or its packages.
   |
   */

    'name' => env('LIBRARY_NAME', 'Library'),

    /*
     |--------------------------------------------------------------------------
     | Default element type
     |--------------------------------------------------------------------------
     */
    'default' => 'plugin',

    /*
     |--------------------------------------------------------------------------
     | Library´s scan
     |--------------------------------------------------------------------------
     */
    'scan' => [
        'filename' => 'apply.json',
        'folder' => base_path('common'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Library plugins assets url  http://domain.com/library/collect:plugin/assets/img.jpg
    |--------------------------------------------------------------------------
    */
    'assets' => [
        'name' => 'library.assets',
        'route' => '/library/{alias}/assets/{patch}',
        //'route' => '/library/assets/{id}/{patch}',
        'controller' =>  Apply\Library\Support\Controllers\Assets::class
    ],
];

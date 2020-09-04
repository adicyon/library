<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Modules namespace
    |--------------------------------------------------------------------------
    |
    | This is the default namespace for the modules
    |
    */
    'namespace' => 'Modules',

    /*
    |--------------------------------------------------------------------------
    | Modules alias
    |--------------------------------------------------------------------------
    |
    | This is the default alias for the packages
    |
    */
    'alias'     => 'module',

    /*
    |--------------------------------------------------------------------------
    | Modules vendor if use composer require or install
    |--------------------------------------------------------------------------
    |
    | This is the default vendor for the module
    |  -> path/vendor/name
    |
    */
    'vendor'     => 'modules',

    /*
    |--------------------------------------------------------------------------
    | POl path
    |--------------------------------------------------------------------------
    |
    | This path used for save the generated module. This path also will added
    | automatically to list of scanned folders.
    |
    */
    'path'  => lib_path('modules'),

    /*
    |--------------------------------------------------------------------------
    | Packages Stubs
    |--------------------------------------------------------------------------
    |
    | Default packages stubs.
    |
    */
    'stubs' => [
        'path' => realpath(LIBRARY_PATH.'/src/Console/stubs'),
        'files'  => [
            'apply'                 => 'apply.json',
            'license'               => 'LICENCE.md',
            'composer'              => 'composer.json',
            'ApplyServiceProvider'  => 'src/Providers/ApplyServiceProvider.php',
            'RouteServiceProvider'  => 'src/Providers/RouteServiceProvider.php',
            'AppServiceProvider'    => 'src/Providers/AppServiceProvider.php',
            'Controller'            => 'src/Http/Controllers/Controller.php',
        ],
    ],
];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'core' => [
        'minPhpVersion' => '8.1.16',
    ],
    'final' => [
        'key' => false,
        'publish' => false,
    ],
    'requirements' => [
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'storage/framework/'     => '755',
        'storage/logs/'          => '755',
        'bootstrap/cache/'       => '755',
    ],

    /*
    |--------------------------------------------------------------------------
    | Artisan Command
    |--------------------------------------------------------------------------
    |
    | Set the artisan commands that you want to run after migrations
    |
    |
    */
    'artisan_command' => [
        'db:seed' => ['--force' => true],
        'testurion:user:create' => [
            '--name' => env('ADMIN_NAME'),
            '--email' => env('ADMIN_EMAIL'),
            '--password' => env('ADMIN_PASSWORD'),
            '--is_admin' => true
        ],
        'testurion:install:clean' => []
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Form Wizard Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form field validation rules. Available Rules:
    | https://laravel.com/docs/5.4/validation#available-validation-rules
    |
    */
    'environment' => [
        'form' => [
            'rules' => [
                'admin_name'            => 'required|string|max:50',
                'admin_email'           => 'required|email|max:50',
                'admin_password'        => 'required|string|max:50',
                'app_name'              => 'required|string|max:50',
                'app_env'               => 'required|string|max:50',
                'environment_custom'    => 'required_if:environment,other|max:50',
                'app_debug'             => 'required|string',
                'log_level'             => 'required|string|max:50',
                'app_url'               => 'required|url',
                'db_connection'         => 'required|string|max:50',
                'db_host'               => 'required|string|max:50',
                'db_port'               => 'required|numeric',
                'db_database'           => 'required|string|max:50',
                'db_username'           => 'required|string|max:50',
                'db_password'           => 'nullable|string|max:50',
                'mail_mailer'           => 'required|string|max:50',
                'mail_host'             => 'required|string|max:50',
                'mail_port'             => 'required|string|max:50',
                'mail_username'         => 'required|string|max:50',
                'mail_password'         => 'required|string|max:50',
                'mail_encryption'       => 'required|string|max:50'
            ],
        ],
        'ignoreOnSave' => ['_token', 'appSettingsTabs'],
        'cleanAfterInstall' => [
            'ADMIN_NAME', 'ADMIN_EMAIL', 'ADMIN_PASSWORD'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Installed Middleware Options
    |--------------------------------------------------------------------------
    | Different available status switch configuration for the
    | canInstall middleware located in `canInstall.php`.
    |
    */
    'installed' => [
        'redirectOptions' => [
            'route' => [
                'name' => 'welcome',
                'data' => [],
            ],
            'abort' => [
                'type' => '404',
            ],
            'dump' => [
                'data' => 'Dumping a not found message.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Selected Installed Middleware Option
    |--------------------------------------------------------------------------
    | The selected option fo what happens when an installer instance has been
    | Default output is to `/resources/views/error/404.blade.php` if none.
    | The available middleware options include:
    | route, abort, dump, 404, default, ''
    |
    */
    'installedAlreadyAction' => '',

    /*
    |--------------------------------------------------------------------------
    | Updater Enabled
    |--------------------------------------------------------------------------
    | Can the application run the '/update' route with the migrations.
    | The default option is set to False if none is present.
    | Boolean value
    |
    */
    'updaterEnabled' => 'true',


];

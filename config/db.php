<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=americor-mysql;dbname=americor-test',
    'username' => env('DB_USERNAME', 'not_root'),
    'password' => env('DB_PASSWORD', 'not_root'),
    'charset' => env('DB_CHARSET', 'utf8'),

    // Schema cache options (for production environment)
    'enableSchemaCache' => env('DB_SCHEMA_CACHE_ENABLED', false),
    'schemaCacheDuration' => env('DB_SCHEMA_CACHE_DURATION', 60),
    'schemaCache' => env('DB_SCHEMA_CACHE', 'cache'),
];

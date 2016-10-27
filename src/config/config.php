<?php

return array(
    'checks' => array(
        'framework' => true,
        'database' => true,
        'cache' => true,
        'flysystem' => 'cdn',
        'storage' => array(
            'conn' => Config::get('connection_string'),
            'source' => Config::get('container_check'),
        ),
        'mail' => array(
            'email' => 'test@example.com',
            'method' => 'queue',
        ),
        'log' => Config::get('connection_string'),
        'cron' => [
            '/etc/cron.d/my_cron_file' => 'artisan custom:command',
        ],
    ),
);
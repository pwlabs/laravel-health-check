<?php

return array(
    'checks' => array(
        'framework' => true,
        'database' => true,
        'flysystem' => 'cdn',
        'storage' => Config::get('connection_string'),
        'mail' => array(
            'email' => 'test@example.com',
            'method' => 'queue',
        ),
        'cron' => [
            '/etc/cron.d/my_cron_file' => 'artisan custom:command',
        ],
    ),
);
<?php

return array(
    'checks' => array(
        'cron' => [
            '/etc/cron.d/my_cron_file' => 'artisan custom:command',
        ],
        'database' => true,
        'flysystem' => 'cdn',
        'framework' => true,
        'mail' => array(
            'email' => 'test@example.com',
            'method' => 'queue',
        ),
    ),
);
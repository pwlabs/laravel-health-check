<?php

// TODO have more "basic" starter values, override in project
return array(
    'checks' => array(
        'database' => true,
        'flysystem' => 'cdn',
        'framework' => true,
        'mail' => array(
            'email' => 'test@example.com',
            'method' => 'queue',
        ),
    ),
);
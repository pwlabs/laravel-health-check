<?php

// TODO have more "basic" starter values, override in project
return array(
    'checks' => array(
        // true will test default db, connection name(s) will test that conn
        'database' => true,
        // enter the key names of any of your configured filesystems
        'filesystem' => array('cdn'),
        'framework' => true,
        'mail' => array(
            'email' => 'test@example.com',
            'method' => 'queue',
        ),
    ),
);
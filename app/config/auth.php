<?php

return array(
    'multi' => array(
        'admin' => array(
            'driver' => 'database',
            'model'  => 'Admin',
            'table'  => 'admin'
        ),
        'user' => array(
            'driver' => 'eloquent',
            'model'  => 'User',
            'table'  => 'users'
        )
    ),
    'reminder' => array(
        'email' => 'emails.auth.reminder',
        'table' => 'password_reminders',
        'expire' => 60,
    ),
);
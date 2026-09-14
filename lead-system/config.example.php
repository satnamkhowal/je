<?php
return [
    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'YOUR_DATABASE_NAME',
        'user' => 'YOUR_DATABASE_USER',
        'pass' => 'YOUR_DATABASE_PASSWORD',
        'charset' => 'utf8mb4',
    ],
    'smtp' => [
        'host' => 'smtp.example.com',
        'port' => 587,
        'username' => 'smtp-user@example.com',
        'password' => 'YOUR_SMTP_PASSWORD',
        'encryption' => 'tls',
        'from_email' => 'info@jaipurengineers.com',
        'from_name' => 'Jaipur Engineers',
        'to_email' => 'info@jaipurengineers.com',
    ],
    'security' => [
        'rate_limit_minutes' => 10,
        'rate_limit_max' => 5,
        'duplicate_hours' => 24,
        'ip_salt' => 'GENERATE_A_LONG_RANDOM_SECRET',
    ],
];

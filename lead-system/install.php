<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$options = getopt('', [
    'db-host::', 'db-port::', 'db-name::', 'db-user::', 'db-pass::',
    'smtp-host::', 'smtp-port::', 'smtp-user::', 'smtp-pass::', 'smtp-encryption::',
    'smtp-from::', 'smtp-from-name::', 'smtp-to::', 'help'
]);

if (isset($options['help'])) {
    echo "Jaipur Engineers lead-system installer\n\n";
    echo "Required: --db-name --db-user --db-pass\n";
    echo "Optional: --db-host=localhost --db-port=3306 and SMTP options.\n";
    echo "Prefer environment variables for passwords: JE_DB_PASS and JE_SMTP_PASS.\n";
    exit(0);
}

$get = static function (string $key, string $env, string $default = '') use ($options): string {
    if (array_key_exists($key, $options) && $options[$key] !== false) {
        return (string)$options[$key];
    }
    $value = getenv($env);
    return $value !== false ? (string)$value : $default;
};

$dbHost = $get('db-host', 'JE_DB_HOST', 'localhost');
$dbPort = (int)$get('db-port', 'JE_DB_PORT', '3306');
$dbName = $get('db-name', 'JE_DB_NAME');
$dbUser = $get('db-user', 'JE_DB_USER');
$dbPass = $get('db-pass', 'JE_DB_PASS');

if ($dbName === '' || $dbUser === '' || $dbPass === '') {
    fwrite(STDERR, "Missing database configuration. Use --help for required options.\n");
    exit(1);
}

$config = [
    'db' => [
        'host' => $dbHost,
        'port' => $dbPort,
        'name' => $dbName,
        'user' => $dbUser,
        'pass' => $dbPass,
        'charset' => 'utf8mb4',
    ],
    'smtp' => [
        'host' => $get('smtp-host', 'JE_SMTP_HOST'),
        'port' => (int)$get('smtp-port', 'JE_SMTP_PORT', '587'),
        'username' => $get('smtp-user', 'JE_SMTP_USER'),
        'password' => $get('smtp-pass', 'JE_SMTP_PASS'),
        'encryption' => $get('smtp-encryption', 'JE_SMTP_ENCRYPTION', 'tls'),
        'from_email' => $get('smtp-from', 'JE_SMTP_FROM', 'info@jaipurengineers.com'),
        'from_name' => $get('smtp-from-name', 'JE_SMTP_FROM_NAME', 'Jaipur Engineers'),
        'to_email' => $get('smtp-to', 'JE_SMTP_TO', 'info@jaipurengineers.com'),
    ],
    'security' => [
        'rate_limit_minutes' => 10,
        'rate_limit_max' => 5,
        'duplicate_hours' => 24,
        'ip_salt' => bin2hex(random_bytes(32)),
    ],
];

$configPath = __DIR__ . '/config.local.php';
if (is_file($configPath)) {
    fwrite(STDERR, "config.local.php already exists. Remove it intentionally before re-running the installer.\n");
    exit(1);
}

try {
    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $dbHost, $dbPort, $dbName);
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $schema = file_get_contents(__DIR__ . '/schema.sql');
    if ($schema === false) {
        throw new RuntimeException('Could not read schema.sql');
    }
    $pdo->exec($schema);

    $php = "<?php\nreturn " . var_export($config, true) . ";\n";
    if (file_put_contents($configPath, $php, LOCK_EX) === false) {
        throw new RuntimeException('Could not write config.local.php');
    }
    @chmod($configPath, 0600);

    echo "Lead database table is ready.\n";
    echo "Local configuration created at lead-system/config.local.php (ignored by Git).\n";
    if (!is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
        echo "Next: run 'composer install --no-dev --optimize-autoloader' from the repository root for SMTP notifications.\n";
    } else {
        echo "Composer dependencies detected; SMTP notification code is ready to use.\n";
    }
    echo "Do not commit config.local.php.\n";
} catch (Throwable $e) {
    fwrite(STDERR, "Installation failed: " . $e->getMessage() . "\n");
    exit(1);
}

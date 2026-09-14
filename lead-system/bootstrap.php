<?php
declare(strict_types=1);

function je_lead_config(): array
{
    static $config;
    if (is_array($config)) {
        return $config;
    }

    $path = __DIR__ . '/config.local.php';
    if (!is_file($path)) {
        throw new RuntimeException('Lead system is not configured. Run the CLI installer first.');
    }

    $loaded = require $path;
    if (!is_array($loaded) || empty($loaded['db'])) {
        throw new RuntimeException('Lead system configuration is invalid.');
    }

    $config = $loaded;
    return $config;
}

function je_lead_pdo(): PDO
{
    static $pdo;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = je_lead_config();
    $db = $config['db'];
    $charset = $db['charset'] ?? 'utf8mb4';
    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $db['host'],
        (int)($db['port'] ?? 3306),
        $db['name'],
        $charset
    );

    $pdo = new PDO($dsn, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function je_lead_log(string $message, array $context = []): void
{
    $dir = __DIR__ . '/logs';
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }

    foreach (['password', 'pass', 'smtp_password', 'db_password'] as $secret) {
        unset($context[$secret]);
    }

    $line = sprintf(
        "[%s] %s %s\n",
        date('c'),
        $message,
        $context ? json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : ''
    );
    @file_put_contents($dir . '/lead-errors.log', $line, FILE_APPEND | LOCK_EX);
}

function je_lead_clean(?string $value, int $max = 255): string
{
    $value = trim((string)$value);
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    return mb_substr($value, 0, $max);
}

function je_lead_phone(?string $value): string
{
    $digits = preg_replace('/\D+/', '', (string)$value) ?? '';
    if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
        $digits = substr($digits, 2);
    }
    return $digits;
}

function je_lead_uuid(): string
{
    $data = random_bytes(16);
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function je_lead_ip_hash(): string
{
    $config = je_lead_config();
    $salt = (string)($config['security']['ip_salt'] ?? '');
    $ip = (string)($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    return hash('sha256', $salt . '|' . $ip);
}

function je_lead_redirect(string $path): never
{
    header('Location: ' . $path, true, 303);
    exit;
}

function je_lead_fail(int $status = 422): never
{
    http_response_code($status);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><html><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Unable to submit enquiry</title></head><body><main style="max-width:680px;margin:60px auto;font-family:Arial,sans-serif;padding:24px"><h1>We could not submit your enquiry.</h1><p>Please check the details and try again, or contact Jaipur Engineers by phone or WhatsApp.</p><p><a href="javascript:history.back()">Go back</a></p></main></body></html>';
    exit;
}

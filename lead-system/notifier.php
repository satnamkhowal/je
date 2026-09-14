<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

function je_notify_lead(array $lead): bool
{
    $config = je_lead_config();
    $smtp = $config['smtp'] ?? [];

    $required = ['host', 'username', 'password', 'from_email', 'to_email'];
    foreach ($required as $key) {
        if (trim((string)($smtp[$key] ?? '')) === '') {
            je_lead_log('Lead saved but SMTP notification skipped: SMTP configuration is incomplete.', [
                'lead_uuid' => $lead['lead_uuid'] ?? null,
                'missing' => $key,
            ]);
            return false;
        }
    }
    if (!filter_var((string)$smtp['from_email'], FILTER_VALIDATE_EMAIL) || !filter_var((string)$smtp['to_email'], FILTER_VALIDATE_EMAIL)) {
        je_lead_log('Lead saved but SMTP notification skipped: From/To email is invalid.', ['lead_uuid' => $lead['lead_uuid'] ?? null]);
        return false;
    }

    $autoload = dirname(__DIR__) . '/vendor/autoload.php';
    if (!is_file($autoload)) {
        je_lead_log('Lead saved but email notification skipped: Composer dependencies are not installed.', ['lead_uuid' => $lead['lead_uuid'] ?? null]);
        return false;
    }

    require_once $autoload;
    if (!class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        je_lead_log('Lead saved but PHPMailer class is unavailable.', ['lead_uuid' => $lead['lead_uuid'] ?? null]);
        return false;
    }

    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = (string)$smtp['host'];
        $mail->Port = (int)($smtp['port'] ?? 587);
        $mail->SMTPAuth = true;
        $mail->Username = (string)$smtp['username'];
        $mail->Password = (string)$smtp['password'];

        $encryption = strtolower((string)($smtp['encryption'] ?? 'tls'));
        if ($encryption === 'ssl' || $encryption === 'smtps') {
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($encryption !== 'none') {
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        }

        $fromEmail = (string)$smtp['from_email'];
        $fromName = (string)($smtp['from_name'] ?? 'Jaipur Engineers');
        $toEmail = (string)$smtp['to_email'];

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail);
        if (!empty($lead['email']) && filter_var($lead['email'], FILTER_VALIDATE_EMAIL)) {
            $mail->addReplyTo($lead['email'], (string)($lead['student_name'] ?? 'Student'));
        }

        $mail->isHTML(true);
        $mail->Subject = 'New Jaipur Engineers Lead - ' . ($lead['interested_course'] ?? 'Course Enquiry');

        $fields = [
            'Lead ID' => $lead['lead_uuid'] ?? '',
            'Name' => $lead['student_name'] ?? '',
            'Phone' => $lead['phone'] ?? '',
            'Email' => $lead['email'] ?? '',
            'City' => $lead['city'] ?? '',
            'Qualification' => $lead['qualification'] ?? '',
            'Course' => $lead['interested_course'] ?? '',
            'Mode' => $lead['preferred_mode'] ?? '',
            'Location' => $lead['preferred_location'] ?? '',
            'Batch' => $lead['preferred_batch'] ?? '',
            'Message' => $lead['message'] ?? '',
            'Source Page' => $lead['source_page'] ?? '',
            'UTM Source' => $lead['utm_source'] ?? '',
            'UTM Campaign' => $lead['utm_campaign'] ?? '',
        ];

        $rows = '';
        foreach ($fields as $label => $value) {
            $rows .= '<tr><th style="text-align:left;padding:8px;border-bottom:1px solid #ddd">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</th><td style="padding:8px;border-bottom:1px solid #ddd">' . nl2br(htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8')) . '</td></tr>';
        }
        $mail->Body = '<h2>New Jaipur Engineers Enquiry</h2><table style="border-collapse:collapse;width:100%;max-width:760px">' . $rows . '</table>';
        $mail->AltBody = implode("\n", array_map(static fn($k, $v) => $k . ': ' . $v, array_keys($fields), array_values($fields)));
        $mail->send();
        return true;
    } catch (Throwable $e) {
        je_lead_log('Lead saved but SMTP notification failed.', [
            'lead_uuid' => $lead['lead_uuid'] ?? null,
            'error' => $e->getMessage(),
        ]);
        return false;
    }
}

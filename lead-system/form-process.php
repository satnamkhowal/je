<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/notifier.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method Not Allowed');
}

try {
    $pdo = je_lead_pdo();
    $config = je_lead_config();

    // Honeypot: bots commonly fill this hidden field.
    if (je_lead_clean($_POST['website'] ?? '', 200) !== '') {
        je_lead_redirect('thank-you.php');
    }

    $lead = [
        'lead_uuid' => je_lead_uuid(),
        'student_name' => je_lead_clean($_POST['name'] ?? '', 120),
        'phone' => je_lead_phone($_POST['phone'] ?? ''),
        'email' => strtolower(je_lead_clean($_POST['email'] ?? '', 190)),
        'city' => je_lead_clean($_POST['city'] ?? '', 100),
        'qualification' => je_lead_clean($_POST['qualification'] ?? '', 120),
        'interested_course' => je_lead_clean($_POST['interested_course'] ?? '', 190),
        'preferred_mode' => je_lead_clean($_POST['preferred_mode'] ?? '', 50),
        'preferred_location' => je_lead_clean($_POST['preferred_location'] ?? '', 120),
        'preferred_batch' => je_lead_clean($_POST['preferred_batch'] ?? '', 80),
        'message' => je_lead_clean($_POST['message'] ?? '', 2500),
        'contact_consent' => isset($_POST['contact_consent']) ? 1 : 0,
        'source_domain' => je_lead_clean($_POST['source_domain'] ?? '', 190),
        'source_page' => je_lead_clean($_POST['source_page'] ?? '', 255),
        'page_title' => je_lead_clean($_POST['page_title'] ?? '', 255),
        'student_segment' => je_lead_clean($_POST['student_segment'] ?? '', 100),
        'landing_page' => je_lead_clean($_POST['landing_page'] ?? '', 255),
        'referrer' => je_lead_clean($_POST['referrer'] ?? '', 500),
        'utm_source' => je_lead_clean($_POST['utm_source'] ?? '', 150),
        'utm_medium' => je_lead_clean($_POST['utm_medium'] ?? '', 150),
        'utm_campaign' => je_lead_clean($_POST['utm_campaign'] ?? '', 190),
        'utm_term' => je_lead_clean($_POST['utm_term'] ?? '', 190),
        'utm_content' => je_lead_clean($_POST['utm_content'] ?? '', 190),
        'ip_hash' => je_lead_ip_hash(),
        'user_agent' => je_lead_clean($_SERVER['HTTP_USER_AGENT'] ?? '', 500),
    ];

    $nameLength = function_exists('mb_strlen') ? mb_strlen($lead['student_name']) : strlen($lead['student_name']);
    if ($nameLength < 2 || strlen($lead['phone']) < 10 || strlen($lead['phone']) > 15) {
        je_lead_fail();
    }
    if (!filter_var($lead['email'], FILTER_VALIDATE_EMAIL) || $lead['interested_course'] === '' || $lead['contact_consent'] !== 1) {
        je_lead_fail();
    }

    $allowedModes = ['', 'Offline', 'Online', 'Hybrid', 'Not sure'];
    if (!in_array($lead['preferred_mode'], $allowedModes, true)) {
        je_lead_fail();
    }

    $security = $config['security'] ?? [];
    $rateMinutes = max(1, (int)($security['rate_limit_minutes'] ?? 10));
    $rateMax = max(1, (int)($security['rate_limit_max'] ?? 5));
    $duplicateHours = max(1, (int)($security['duplicate_hours'] ?? 24));

    // duplicate_count is included so repeated submissions of the same lead also consume the rate limit.
    $rateSql = "SELECT COALESCE(SUM(1 + duplicate_count), 0) FROM je_leads WHERE ip_hash = :ip_hash AND COALESCE(last_seen_at, created_at) >= DATE_SUB(NOW(), INTERVAL {$rateMinutes} MINUTE)";
    $rate = $pdo->prepare($rateSql);
    $rate->execute(['ip_hash' => $lead['ip_hash']]);
    if ((int)$rate->fetchColumn() >= $rateMax) {
        je_lead_log('Lead rate limit reached.', ['ip_hash' => $lead['ip_hash']]);
        je_lead_fail(429);
    }

    $duplicateSql = "SELECT id, lead_uuid FROM je_leads WHERE phone = :phone AND interested_course = :course AND created_at >= DATE_SUB(NOW(), INTERVAL {$duplicateHours} HOUR) ORDER BY id DESC LIMIT 1";
    $duplicate = $pdo->prepare($duplicateSql);
    $duplicate->execute(['phone' => $lead['phone'], 'course' => $lead['interested_course']]);
    $existing = $duplicate->fetch();

    if ($existing) {
        $update = $pdo->prepare('UPDATE je_leads SET duplicate_count = duplicate_count + 1, last_seen_at = NOW() WHERE id = :id');
        $update->execute(['id' => $existing['id']]);
        je_lead_redirect('thank-you.php?ref=' . rawurlencode((string)$existing['lead_uuid']));
    }

    $sql = 'INSERT INTO je_leads (
        lead_uuid, student_name, phone, email, city, qualification, interested_course,
        preferred_mode, preferred_location, preferred_batch, message, contact_consent,
        source_domain, source_page, page_title, student_segment, landing_page, referrer,
        utm_source, utm_medium, utm_campaign, utm_term, utm_content,
        ip_hash, user_agent
    ) VALUES (
        :lead_uuid, :student_name, :phone, :email, :city, :qualification, :interested_course,
        :preferred_mode, :preferred_location, :preferred_batch, :message, :contact_consent,
        :source_domain, :source_page, :page_title, :student_segment, :landing_page, :referrer,
        :utm_source, :utm_medium, :utm_campaign, :utm_term, :utm_content,
        :ip_hash, :user_agent
    )';

    $insert = $pdo->prepare($sql);
    $insert->execute($lead);

    // Database is authoritative: notification failure never rolls back a valid lead.
    je_notify_lead($lead);
    je_lead_redirect('thank-you.php?ref=' . rawurlencode($lead['lead_uuid']));
} catch (Throwable $e) {
    je_lead_log('Lead submission failed.', ['error' => $e->getMessage()]);
    je_lead_fail(503);
}

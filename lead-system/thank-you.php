<?php
$ref = isset($_GET['ref']) ? preg_replace('/[^a-f0-9-]/i', '', (string)$_GET['ref']) : '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title>Enquiry Received | Jaipur Engineers</title>
  <style>
    *{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:#fff8f3;color:#111318}.wrap{min-height:100vh;display:grid;place-items:center;padding:28px}.card{width:min(680px,100%);background:#fff;border:1px solid #eee2da;border-radius:24px;padding:42px;box-shadow:0 24px 70px rgba(17,19,24,.1)}.icon{width:64px;height:64px;border-radius:50%;display:grid;place-items:center;background:#fff0e6;color:#ff731e;font-size:30px;font-weight:700}.card h1{font-size:38px;line-height:1.1;margin:22px 0 14px}.card p{color:#616773;line-height:1.7}.ref{font-size:12px;color:#8a8f98;background:#f7f4f1;padding:10px 12px;border-radius:10px;word-break:break-all}.actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:24px}.btn{display:inline-block;text-decoration:none;border-radius:999px;padding:13px 20px;font-weight:700}.primary{background:#ff731e;color:#fff}.dark{background:#111318;color:#fff}
  </style>
</head>
<body>
  <main class="wrap">
    <section class="card">
      <div class="icon">✓</div>
      <h1>Your enquiry has been received.</h1>
      <p>Thank you for contacting Jaipur Engineers. Your details have been recorded. The counselling team can use them to follow up about the course, batch mode and schedule.</p>
      <?php if ($ref): ?><p class="ref">Reference: <?= htmlspecialchars($ref, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
      <div class="actions">
        <a class="btn primary" href="../python-full-stack/">Back to Python Full Stack</a>
        <a class="btn dark" href="tel:+917014692039">Call Jaipur Engineers</a>
      </div>
    </section>
  </main>
</body>
</html>

<?php
$clip = static function (string $value, int $max): string {
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
};
$name = isset($_GET['name']) ? $clip(trim((string)$_GET['name']), 120) : '';
$phoneRaw = isset($_GET['phone']) ? (preg_replace('/[^0-9+() -]/', '', (string)$_GET['phone']) ?? '') : '';
$phone = $clip($phoneRaw, 25);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="robots" content="noindex,follow">
  <title>Python Full Stack Course Enquiry | Jaipur Engineers</title>
  <meta name="description" content="Request counselling for the Python Full Stack Developer course at Jaipur Engineers in Jaipur.">
  <link rel="icon" href="../assets/images/jaipur-engieers-favicon-icon.png" type="image/png">
  <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="../java-full-stack/assets/css/landing.css">
  <link rel="stylesheet" href="assets/css/enquiry.css">
</head>
<body>
<div class="topbar"><div class="container"><div class="topbar-left"><span><i class="fa fa-bolt"></i> Established 1996</span><span><i class="fa fa-map-marker"></i> Mansarovar, Jaipur</span></div><div class="topbar-right"><span>Training</span><span>Internship</span><span>Staffing</span></div></div></div>
<header class="site-header"><div class="container navbar"><a class="brand" href="../" aria-label="Jaipur Engineers home"><img src="../assets/images/jaipur-engieers-logo.png" alt="Jaipur Engineers"></a><div class="nav-actions" style="margin-left:auto"><a class="btn btn-outline" href="tel:+917014692039"><i class="fa fa-phone"></i> Call</a></div></div></header>

<main class="enquiry-shell">
  <div class="container">
    <a class="back-link" href="./"><i class="fa fa-arrow-left"></i> Back to Python Full Stack course</a>
    <div class="enquiry-layout">
      <aside class="enquiry-info">
        <div class="eyebrow">Course Counselling</div>
        <h1>Python Full Stack Developer Course</h1>
        <p>Tell us your current level and preferred learning mode. The details are saved securely so the counselling team can follow up with current batch information.</p>
        <div class="enquiry-points">
          <span><i class="fa fa-check-circle"></i> Python, Django, REST APIs, SQL and React roadmap</span>
          <span><i class="fa fa-check-circle"></i> Offline and online enquiry options</span>
          <span><i class="fa fa-check-circle"></i> Practical projects and portfolio-focused learning</span>
          <span><i class="fa fa-check-circle"></i> Exact fee and batch timing confirmed during counselling</span>
        </div>
      </aside>

      <section class="enquiry-card">
        <h2>Complete your enquiry</h2>
        <p>Fields marked required are used to respond to your course enquiry.</p>
        <form class="enquiry-form" method="post" action="../lead-system/form-process.php" autocomplete="on">
          <div class="field-grid">
            <div class="field"><label for="name">Student name *</label><input id="name" name="name" type="text" maxlength="120" required autocomplete="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"></div>
            <div class="field"><label for="phone">Mobile number *</label><input id="phone" name="phone" type="tel" maxlength="25" required inputmode="tel" autocomplete="tel" value="<?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?>"></div>
            <div class="field"><label for="email">Email *</label><input id="email" name="email" type="email" maxlength="190" required autocomplete="email"></div>
            <div class="field"><label for="city">City</label><input id="city" name="city" type="text" maxlength="100" autocomplete="address-level2" value="Jaipur"></div>
            <div class="field"><label for="qualification">Current qualification</label><input id="qualification" name="qualification" type="text" maxlength="120" placeholder="e.g. BCA, MCA, B.Tech, Graduate"></div>
            <div class="field"><label for="preferred_mode">Preferred mode</label><select id="preferred_mode" name="preferred_mode"><option value="Not sure">Not sure</option><option value="Offline">Offline</option><option value="Online">Online</option><option value="Hybrid">Hybrid</option></select></div>
            <div class="field"><label for="preferred_location">Preferred location</label><select id="preferred_location" name="preferred_location"><option value="Mansarovar, Jaipur">Mansarovar, Jaipur</option><option value="Live Online">Live Online</option><option value="Not sure">Not sure</option></select></div>
            <div class="field"><label for="preferred_batch">Preferred batch</label><select id="preferred_batch" name="preferred_batch"><option value="Not sure">Not sure</option><option value="Morning">Morning</option><option value="Evening">Evening</option><option value="Weekend">Weekend</option></select></div>
            <div class="field full"><label for="message">Message</label><textarea id="message" name="message" maxlength="2500" placeholder="Tell us what you want to learn or ask about the next batch."></textarea></div>
          </div>

          <label class="consent"><input type="checkbox" name="contact_consent" value="1" required> <span>I agree that Jaipur Engineers may contact me about this course enquiry by phone, WhatsApp or email. *</span></label>

          <div class="hp-field" aria-hidden="true"><label for="website">Website</label><input id="website" type="text" name="website" tabindex="-1" autocomplete="off"></div>

          <input type="hidden" name="interested_course" value="Python Full Stack Developer Course in Jaipur">
          <input type="hidden" name="source_domain" value="">
          <input type="hidden" name="source_page" value="">
          <input type="hidden" name="page_title" value="Python Full Stack Course Enquiry | Jaipur Engineers">
          <input type="hidden" name="student_segment" value="">
          <input type="hidden" name="landing_page" value="">
          <input type="hidden" name="referrer" value="">
          <input type="hidden" name="utm_source" value="">
          <input type="hidden" name="utm_medium" value="">
          <input type="hidden" name="utm_campaign" value="">
          <input type="hidden" name="utm_term" value="">
          <input type="hidden" name="utm_content" value="">

          <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Submit Course Enquiry</button>
          <p class="form-help">Your enquiry is stored in the lead database before any email notification is attempted.</p>
        </form>
      </section>
    </div>
  </div>
</main>
<script>
(function(){
  var form=document.querySelector('.enquiry-form');
  if(!form)return;
  var params=new URLSearchParams(window.location.search);
  var set=function(name,value){var el=form.querySelector('[name="'+name+'"]');if(el)el.value=value||'';};
  set('source_domain',window.location.hostname);
  set('source_page',window.location.pathname);
  set('landing_page',window.location.href.split('#')[0]);
  set('referrer',document.referrer);
  ['utm_source','utm_medium','utm_campaign','utm_term','utm_content','student_segment'].forEach(function(key){set(key,params.get(key)||'');});
})();
</script>
</body>
</html>

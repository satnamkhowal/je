<?php
$enquiryEyebrow = $enquiryEyebrow ?? 'Request Counselling';
$enquiryHeading = $enquiryHeading ?? 'What would you like to learn?';
$enquiryIntro = $enquiryIntro ?? 'Share a few details and the Jaipur Engineers team can respond with current course, mode and batch guidance.';
$enquiryPageTitle = $enquiryPageTitle ?? 'IT Course Enquiry | Jaipur Engineers';
$leadHandlerPath = $leadHandlerPath ?? 'lead-system/form-process.php';
$enquirySectionClass = $enquirySectionClass ?? 'je-enquiry-section pt-100 pb-100 md-pt-70 md-pb-70';

$enquiryCourses = [
    'Full Stack Development',
    'Java Programming',
    'Python Programming',
    'Data Science and Artificial Intelligence',
    'Cloud Computing and DevOps',
    'Cyber Security',
    'Software Testing',
    'Digital Marketing',
    'Internship or Project Training',
    'Other IT Course',
];

$requestedCourse = isset($_GET['course']) ? trim((string) $_GET['course']) : '';
$selectedCourse = in_array($requestedCourse, $enquiryCourses, true) ? $requestedCourse : '';

$escape = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};
?>
<section id="course-enquiry" class="<?= $escape($enquirySectionClass) ?>" aria-labelledby="enquiry-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 md-mb-40">
                <span class="je-eyebrow"><?= $escape($enquiryEyebrow) ?></span>
                <h2 id="enquiry-heading"><?= $escape($enquiryHeading) ?></h2>
                <p><?= $escape($enquiryIntro) ?></p>
                <ul class="je-enquiry-points">
                    <li><i class="fa fa-check-circle" aria-hidden="true"></i> Course and learning-path guidance</li>
                    <li><i class="fa fa-check-circle" aria-hidden="true"></i> Internship and live-project enquiries</li>
                    <li><i class="fa fa-check-circle" aria-hidden="true"></i> Online, offline and hybrid preferences</li>
                    <li><i class="fa fa-check-circle" aria-hidden="true"></i> Current details confirmed by the counselling team</li>
                </ul>
            </div>

            <div class="col-lg-7">
                <div class="je-enquiry-card">
                    <form class="je-enquiry-form" method="post" action="<?= $escape($leadHandlerPath) ?>" autocomplete="on">
                        <div class="row">
                            <div class="col-md-6 mb-25">
                                <label for="name">Name <span aria-hidden="true">*</span></label>
                                <input id="name" name="name" type="text" maxlength="120" required autocomplete="name">
                            </div>
                            <div class="col-md-6 mb-25">
                                <label for="phone">Mobile number <span aria-hidden="true">*</span></label>
                                <input id="phone" name="phone" type="tel" maxlength="25" required inputmode="tel" autocomplete="tel">
                            </div>
                            <div class="col-md-6 mb-25">
                                <label for="email">Email <span aria-hidden="true">*</span></label>
                                <input id="email" name="email" type="email" maxlength="190" required autocomplete="email">
                            </div>
                            <div class="col-md-6 mb-25">
                                <label for="city">City</label>
                                <input id="city" name="city" type="text" maxlength="100" autocomplete="address-level2" value="Jaipur">
                            </div>
                            <div class="col-md-6 mb-25">
                                <label for="interested_course">Interested in <span aria-hidden="true">*</span></label>
                                <select id="interested_course" name="interested_course" required>
                                    <option value="">Select a course or program</option>
                                    <?php foreach ($enquiryCourses as $course): ?>
                                        <option value="<?= $escape($course) ?>"<?= $course === $selectedCourse ? ' selected' : '' ?>>
                                            <?= $escape($course === 'Data Science and Artificial Intelligence' ? 'Data Science & Artificial Intelligence' : ($course === 'Cloud Computing and DevOps' ? 'Cloud Computing & DevOps' : $course)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-25">
                                <label for="preferred_mode">Preferred mode</label>
                                <select id="preferred_mode" name="preferred_mode">
                                    <option value="Not sure">Not sure</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Online">Online</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                            </div>
                            <div class="col-12 mb-25">
                                <label for="message">What guidance do you need?</label>
                                <textarea id="message" name="message" maxlength="2500" rows="5" placeholder="Tell us about your course, internship, project or career-training requirement."></textarea>
                            </div>
                        </div>

                        <label class="je-consent">
                            <input type="checkbox" name="contact_consent" value="1" required>
                            <span>I agree that Jaipur Engineers may contact me about this enquiry by phone, WhatsApp or email. <span aria-hidden="true">*</span></span>
                        </label>

                        <div class="je-hp-field" aria-hidden="true">
                            <label for="website">Website</label>
                            <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                        </div>

                        <input type="hidden" name="qualification" value="">
                        <input type="hidden" name="preferred_location" value="">
                        <input type="hidden" name="preferred_batch" value="">
                        <input type="hidden" name="source_domain" value="">
                        <input type="hidden" name="source_page" value="">
                        <input type="hidden" name="page_title" value="<?= $escape($enquiryPageTitle) ?>">
                        <input type="hidden" name="student_segment" value="">
                        <input type="hidden" name="landing_page" value="">
                        <input type="hidden" name="referrer" value="">
                        <input type="hidden" name="utm_source" value="">
                        <input type="hidden" name="utm_medium" value="">
                        <input type="hidden" name="utm_campaign" value="">
                        <input type="hidden" name="utm_term" value="">
                        <input type="hidden" name="utm_content" value="">

                        <button class="readon2 cta-btn je-submit" type="submit">Submit Enquiry <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        <p class="je-form-note">Required fields help us respond to your enquiry. Your details are saved before an email notification is attempted.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var form = document.querySelector('.je-enquiry-form');
    if (!form) return;
    var params = new URLSearchParams(window.location.search);
    var setValue = function (name, value) {
        var field = form.querySelector('[name="' + name + '"]');
        if (field) field.value = value || '';
    };
    setValue('source_domain', window.location.hostname);
    setValue('source_page', window.location.pathname);
    setValue('landing_page', window.location.href.split('#')[0]);
    setValue('referrer', document.referrer);
    ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'student_segment'].forEach(function (key) {
        setValue(key, params.get(key) || '');
    });
})();
</script>

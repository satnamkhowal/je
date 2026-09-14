<?php
/**
 * Python Full Stack landing page data.
 * Keep fast-changing items such as fee, exact batch dates and seat availability out of static code.
 */
$je = [
    'name' => 'Jaipur Engineers',
    'phone_display' => '+91 70146 92039',
    'phone' => '+917014692039',
    'email' => 'info@jaipurengineers.com',
    'address' => '122/228, Indra Path, Madhyam Marg, Mansarovar, Jaipur, Rajasthan 302020',
    'website' => 'https://jaipurengineers.com/',
    'whatsapp' => '917014692039',
];

$course = [
    'name' => 'Python Full Stack Developer Course in Jaipur',
    'short_name' => 'Python Full Stack',
    'duration' => '5–6 Months',
    'sections' => '8 Career Modules',
    'projects' => '4+ Projects',
    'mode' => 'Offline + Online',
    'description' => 'Learn Python, Django, REST APIs, React, SQL, Git and deployment through practical full stack projects with Jaipur Engineers.',
    'canonical' => 'https://jaipurengineers.com/python-full-stack/',
];

function je_whatsapp_url(string $message): string {
    global $je;
    return 'https://wa.me/' . $je['whatsapp'] . '?text=' . rawurlencode($message);
}

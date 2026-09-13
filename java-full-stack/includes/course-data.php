<?php
/**
 * Java Full Stack landing page data.
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
    'name' => 'Java Full Stack Developer Course in Jaipur',
    'short_name' => 'Java Full Stack',
    'duration' => '10 Weeks',
    'sections' => '15 Sections',
    'lessons' => '80 Lessons',
    'mode' => 'Offline + Online',
    'description' => 'Learn Core Java, Spring Boot, Hibernate, React, MySQL, REST APIs, Git, Docker and project development with mentor-led training at Jaipur Engineers.',
];

function je_whatsapp_url(string $message): string {
    global $je;
    return 'https://wa.me/' . $je['whatsapp'] . '?text=' . rawurlencode($message);
}

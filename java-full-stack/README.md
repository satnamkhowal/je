# Jaipur Engineers — Java Full Stack Landing Page

A dedicated Java Full Stack Developer landing page built for Jaipur Engineers using the existing official logo assets and the orange / black / white brand direction.

## Files

```text
java-full-stack/
├── index.html                         # Standalone static version
├── index.php                          # Modular PHP entry point
├── README.md
├── assets/
│   ├── java-full-stack-thumbnail.svg  # 1280×720 branded course thumbnail
│   ├── css/landing.css
│   └── js/landing.js
└── includes/
    ├── course-data.php                # Contact + course metadata
    ├── head.php
    ├── header.php
    ├── hero.php
    ├── course-content.php
    └── footer.php
```

## Content included

- Premium responsive hero and course thumbnail
- Core Java, Spring Boot, Hibernate, MySQL, React, REST API, Git and Docker stack
- Course outcomes and grouped curriculum roadmap
- Mentor cards for Jai Singh and Rohit Mehra
- Morning, evening and weekend batch enquiry cards
- Published student-feedback paraphrases
- Portfolio project section
- FAQ accordion
- WhatsApp lead form and mobile call/WhatsApp CTA
- SEO title/description and Course JSON-LD

## Important maintenance notes

Exact batch start dates, timings, fees and seat counts are intentionally not hardcoded because they change. The page asks the counsellor for the current information instead.

Current contact details are centralized in `includes/course-data.php` for the PHP version. The static HTML contains the same values directly.

The course thumbnail references the repository's official Jaipur Engineers logo asset instead of redrawing the logo.

## Current public information used

Course structure and technology coverage were aligned with the current Jaipur Engineers Java Full Stack course page. Trainer titles/experience and student-feedback summaries were aligned with the current Jaipur Engineers website at the time this landing page was created.

- Main site: https://jaipurengineers.com/
- Java Full Stack course: https://jaipurengineers.com/courses/java-full-stack-developer-course-jaipur/
- Contact: https://jaipurengineers.com/contact/

Before production deployment, confirm any time-sensitive trainer assignment, batch schedule, fee or placement claim with the Jaipur Engineers team.

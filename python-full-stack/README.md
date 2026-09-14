# Jaipur Engineers — Python Full Stack Landing Page

Dedicated Python Full Stack Developer landing page for Jaipur Engineers, built to match the premium Java Full Stack design system while keeping course-specific content modular.

## Route

```text
/python-full-stack/
```

## Files

```text
python-full-stack/
├── index.php
├── README.md
├── assets/
│   ├── python-full-stack-thumbnail.svg
│   └── js/landing.js
└── includes/
    ├── course-data.php
    ├── head.php
    ├── header.php
    ├── hero.php
    ├── course-content.php
    └── footer.php
```

The page intentionally reuses the existing Java Full Stack landing-page CSS at `../java-full-stack/assets/css/landing.css` so typography, spacing, responsiveness and brand styling stay consistent.

## Content coverage

- Python programming fundamentals and OOP
- HTML, CSS and JavaScript foundations
- SQL and relational database design
- Django web development and ORM
- REST API development
- React frontend integration
- Git/GitHub and deployment fundamentals
- Portfolio projects and career-readiness sections
- Responsive batch enquiry cards, FAQ accordion and WhatsApp lead flow
- SEO title, meta description, canonical and Course JSON-LD

## Maintenance notes

Current fees, exact batch start dates, timings, trainer allocation and seat counts are intentionally not hardcoded because they can change. Counselling CTAs should be used for those details.

Contact/course metadata is centralized in `includes/course-data.php`.

The course thumbnail references the repository's existing Jaipur Engineers logo asset rather than recreating the logo.

# Jaipur Engineers Lead System

Database-first enquiry handling for Jaipur Engineers course landing pages.

## What it does

- Saves a validated enquiry to MySQL before attempting email notification.
- Captures student/course preferences plus source, referrer and UTM tracking fields.
- Uses prepared PDO statements.
- Requires explicit contact consent.
- Includes a honeypot field, hashed-IP rate limiting and 24-hour same-phone/course duplicate protection.
- Sends authenticated SMTP notifications through PHPMailer when SMTP is configured.
- Logs SMTP/runtime failures without exposing database or SMTP errors to visitors.
- Keeps `config.local.php` outside Git through `.gitignore`.

## Requirements

- PHP 8.0+
- PDO MySQL extension
- MySQL / MariaDB
- Composer for PHPMailer SMTP notifications

## Install dependencies

From the repository root:

```bash
composer install --no-dev --optimize-autoloader
```

## Configure database and SMTP

The safest approach is to keep passwords out of shell history and use environment variables for them:

```bash
export JE_DB_PASS='YOUR_DATABASE_PASSWORD'
export JE_SMTP_PASS='YOUR_SMTP_PASSWORD'

php lead-system/install.php \
  --db-host=localhost \
  --db-port=3306 \
  --db-name=YOUR_DATABASE_NAME \
  --db-user=YOUR_DATABASE_USER \
  --smtp-host=YOUR_SMTP_HOST \
  --smtp-port=587 \
  --smtp-user=YOUR_SMTP_USER \
  --smtp-encryption=tls \
  --smtp-from=info@jaipurengineers.com \
  --smtp-from-name='Jaipur Engineers' \
  --smtp-to=YOUR_MONITORED_LEAD_EMAIL
```

The installer creates the `je_leads` table and writes `lead-system/config.local.php`. That local file contains secrets and must never be committed.

If needed, all installer values can also be supplied through these environment variables:

- `JE_DB_HOST`, `JE_DB_PORT`, `JE_DB_NAME`, `JE_DB_USER`, `JE_DB_PASS`
- `JE_SMTP_HOST`, `JE_SMTP_PORT`, `JE_SMTP_USER`, `JE_SMTP_PASS`
- `JE_SMTP_ENCRYPTION`, `JE_SMTP_FROM`, `JE_SMTP_FROM_NAME`, `JE_SMTP_TO`

## Current Python Full Stack flow

`/python-full-stack/` → quick name/phone step → `/python-full-stack/enquire.php` → `lead-system/form-process.php` → MySQL → SMTP attempt → `lead-system/thank-you.php`.

The detailed form captures:

- Name, phone, email, city and qualification
- Interested course
- Preferred mode, location and batch
- Message and contact consent
- Source domain/page, page title, landing page and referrer
- UTM source, medium, campaign, term and content

## Operational notes

- A valid lead stays in MySQL even if Composer, PHPMailer or SMTP is unavailable.
- Error logs are written to `lead-system/logs/lead-errors.log` and ignored by Git.
- The thank-you page is `noindex,nofollow`.
- Duplicate submissions for the same phone + course within the configured window increment `duplicate_count` instead of creating repeated lead rows.
- Rate limiting uses a salted hash of the visitor IP rather than storing the raw IP address.

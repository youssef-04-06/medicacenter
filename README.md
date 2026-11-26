# HospiBridge

HospiBridge is a Laravel 12 healthcare platform for connecting patients, doctors, and administrators through appointment booking, symptom-guided triage, telemedicine support, and prescription management.

## What HospiBridge does

- Lets patients browse services, register, and book appointments with doctors
- Provides a guided symptom check-in that matches common keywords to a likely specialty and doctor
- Supports telemedicine appointments with Zoom meeting links and WhatsApp notifications
- Lets doctors review requests, manage schedules, accept or reject appointments, and issue prescriptions
- Gives administrators control over bookings, payments, messages, prescriptions, and doctor records
- Generates PDF prescriptions with dompdf

## Tech stack

- Laravel 12
- Blade templates
- Tailwind CSS
- Alpine.js
- Vite for frontend build assets
- MySQL for application data storage
- Zoom REST API for telemedicine sessions
- WhatsApp Cloud API via Twilio for appointment and follow-up notifications
- dompdf for PDF prescription generation
- Pest for automated tests

## Project structure

- `app/` — controllers, models, services, and providers
- `resources/views/` — Blade views for the landing page, dashboards, and forms
- `routes/web.php` — application routes
- `database/migrations/` — schema definitions
- `tests/` — Pest test coverage
- `public/` and `resources/js/` — frontend assets compiled with Vite

## Roles

### Patient
- Create an account and sign in
- Search for services and book an appointment
- Use the guided symptom assessment flow to get pointed toward the right specialty/doctor
- Track appointment status, view reminders, and join telemedicine sessions when approved
- Request prescriptions and view notices from the clinic

### Doctor
- Access a dedicated doctor dashboard
- Review appointment requests assigned to the doctor
- Accept, reject, or reschedule bookings
- Join Zoom telemedicine meetings for approved consultations
- Issue prescriptions and manage related patient communication

### Admin
- Manage users, doctors, schedules, appointments, and payments
- Review messages and communication history
- Approve or coordinate telemedicine sessions
- Handle prescription requests and view platform activity

## Local setup

1. Install PHP dependencies:
   ```bash
   composer install
   ```

2. Install frontend dependencies:
   ```bash
   npm install
   ```

3. Copy the environment file and configure your local settings:
   ```bash
   copy .env.example .env
   ```
   Then update the `.env` file with your database credentials, Zoom credentials, Twilio/WhatsApp settings, and app URL.

4. Generate the application key and run database migrations:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. Start the development servers:
   ```bash
   npm run dev
   ```

6. In a separate terminal, run the Laravel application:
   ```bash
   php artisan serve
   ```

## Production note

Set `APP_DEBUG=false` in production before deployment, even if `.env.example` defaults to `true` for local development.

## Testing

The project includes Pest tests covering booking flows, authentication, prescription requests, and Zoom link generation. You can run them with:

```bash
php artisan test
```

## Common environment variables

The `.env.example` file includes placeholders for:

- `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `ZOOM_ACCOUNT_ID`, `ZOOM_CLIENT_ID`, `ZOOM_CLIENT_SECRET`
- `TWILIO_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_WHATSAPP_FROM`

Make sure these are filled in before running the app locally or deploying it.

## License

This project is provided as-is for learning and demonstration purposes.

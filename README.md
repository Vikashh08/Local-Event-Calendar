# LECS — Local Event Calendar System

A full-featured event management platform built with Laravel 12, Tailwind CSS, and Alpine.js.

## Features
- Multi-role auth (Admin / Organizer / Attendee)
- Event creation, ticketing & paid bookings
- Digital QR entry passes
- RSVP management & bookmarks
- Organizer revenue dashboard
- Admin moderation panel

## Tech Stack
- **Backend:** Laravel 12, PHP 8.3
- **Frontend:** Tailwind CSS v4, Alpine.js, Vite
- **Database:** MySQL

## Deploy on Railway

1. Create a new project on [railway.app](https://railway.app)
2. Add a **MySQL** plugin to your project
3. Connect this GitHub repo
4. Add these environment variables in Railway dashboard:

```
APP_NAME=LECS
APP_ENV=production
APP_DEBUG=false
APP_KEY=          ← Railway will generate via nixpacks
APP_URL=          ← Your Railway public URL

DB_CONNECTION=mysql
DB_HOST=          ← from Railway MySQL plugin (MYSQLHOST)
DB_PORT=          ← from Railway MySQL plugin (MYSQLPORT)
DB_DATABASE=      ← from Railway MySQL plugin (MYSQLDATABASE)
DB_USERNAME=      ← from Railway MySQL plugin (MYSQLUSER)
DB_PASSWORD=      ← from Railway MySQL plugin (MYSQLPASSWORD)

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Railway auto-injects `MYSQL_*` variables from the MySQL plugin — just map them.

## Local Development

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

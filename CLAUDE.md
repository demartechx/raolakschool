# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Raolak School is a dual-platform education/fintech application:
- **Flutter app** (`lib/`) — mobile and web client (Android, iOS, Web, macOS, Linux, Windows)
- **Laravel backend** (`portal/`) — REST API, admin dashboard, and payment processing

---

## Flutter App Commands

```bash
# Install dependencies
flutter pub get

# Run app
flutter run                  # interactive device selection
flutter run -d android
flutter run -d web

# Build
flutter build apk
flutter build web

# Test & lint
flutter test
flutter analyze
```

---

## Laravel Portal Commands

All commands run from `portal/`:

```bash
# First-time setup (installs deps, copies .env, generates key, migrates, builds frontend)
composer run setup

# Start all dev servers concurrently (Laravel + queue + log viewer + Vite)
composer run dev

# Individual servers
php artisan serve            # port 8000
npm run dev                  # Vite HMR
php artisan queue:listen
php artisan pail             # log viewer

# Database
php artisan migrate
php artisan migrate:fresh --seed

# Tests
composer run test            # clears config then runs PHPUnit
php artisan test --filter=TestName   # single test
```

---

## Architecture

### Flutter (`lib/`)

Organized into four layers:

| Directory   | Purpose |
|-------------|---------|
| `screens/`  | Top-level route screens (one file per screen) |
| `sections/` | Large UI sections composed inside screens |
| `widgets/`  | Reusable, stateless UI components |
| `models/`   | Plain Dart data classes |
| `constants/`| App-wide colors (`app_colors.dart`) and strings (`app_strings.dart`) |

Entry point: [lib/main.dart](lib/main.dart)

### Laravel Portal (`portal/app/`)

Follows a **Service + MVC** pattern:

- **Controllers** (`Http/Controllers/`) — thin; delegate business logic to Services
- **Services/** — core business logic: `WalletService` (credit/debit with DB transactions), `AccountService`, `Payment/` (Monnify gateway wrapper)
- **Models/** — Eloquent: `User` → `VirtualAccount` (1:1), `User` → `WalletHistory` (1:many), `User` → `Enrollment` (1:many)
- **Filament Resources** (`Filament/Resources/`) — auto-generated admin CRUD UI for User, Enrollment, WalletHistory, VirtualAccount
- **Webhooks** — `WebhookController` handles async Monnify payment notifications and triggers wallet credits

### Payment Flow

1. User requests enrollment/wallet top-up
2. `AccountService` creates a Monnify virtual bank account
3. User transfers funds to that account externally
4. Monnify POSTs a webhook to `WebhookController`
5. `WalletService` credits wallet inside a DB transaction and logs to `WalletHistory`

### Authentication

- **Admin panel** — session-based via Filament
- **Flutter API** — Laravel Sanctum token authentication

### Deployment Note

The portal is deployed in a subdirectory. `AppServiceProvider` overrides `livewire.asset_url` at runtime using `APP_URL` to avoid 405 errors. When changing URL-related config, check `portal/app/Providers/AppServiceProvider.php` first.

---

## Key Config Files

| File | Purpose |
|------|---------|
| `pubspec.yaml` | Flutter deps (http, flutter_animate, url_launcher) |
| `portal/composer.json` | PHP deps (Laravel 12, Filament 3.2, Sanctum 4) |
| `portal/config/payment.php` | Monnify gateway credentials/endpoints |
| `portal/.env` | Runtime environment (DB, queue, mail, APP_URL) |
| `portal/vite.config.js` | Frontend bundling (Tailwind, Alpine.js, Axios) |

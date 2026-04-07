# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A Laravel 9 receipt management system ("Recibo") built with Laravel Splade (SSR-capable SPA framework using Vue 3). The app generates, prints, and verifies payment receipts with QR codes for authenticity.

## Common Commands

```bash
# Install dependencies
composer install
npm install

# Frontend dev server (Vite with HMR)
npm run dev

# Build frontend for production (includes SSR build)
npm run build

# Run database migrations
php artisan migrate

# Seed initial data (creates default admin user william@gmail.com)
php artisan db:seed

# Seed roles only
php artisan db:seed --class=RoleSeeder

# Run tests
php artisan test

# Run a single test
php artisan test --filter TestName

# Laravel Pint (code style fixer)
./vendor/bin/pint

# Clear all caches
php artisan optimize:clear
```

## Architecture

### Stack
- **Laravel 9** + **PHP 8.0+**
- **Laravel Splade** (`protonemedia/laravel-splade`) — provides SPA-like navigation using Vue 3 components embedded in Blade templates. All routes are wrapped in `Route::middleware('splade')`.
- **Spatie Laravel Permission** — role/permission system. Admin role gates are checked inline via `auth()->user()->hasRole('admin')`.
- **Spatie Query Builder** — powers filterable/sortable paginated tables via `SpladeTable`.
- **DomPDF** (`barryvdh/laravel-dompdf`) — generates PDF receipts.
- **chillerlan/php-qrcode** — generates QR codes embedded as base64 PNG in PDFs.
- **TailwindCSS 3** with `@tailwindcss/forms` and `@tailwindcss/typography`.

### Key Models
- **`Recibo`** — core entity. Fields: `nro_serie` (auto-incremented serial, zero-padded via accessor), `hash` (MD5 of `nro_serie + fecha + cliente_id + cantidad + concepto` — used for QR verification URL), `fecha`, `cliente_id`, `cantidad`, `cantidad_literal`, `concepto`, `observaciones`, `user_id`, `estado` (0=Anulado, 1=Registrado, 2=Aprobado).
- **`Persona`** — client/person entity. Has `nombres`, `ap_paterno`, `ap_materno` (auto-capitalized via `CapitalizeWordsCast`), and a computed `nombre_completo` attribute.
- **`User`** — standard Laravel auth user with `is_active` column and Spatie roles.

### Key Controllers
- **`ReciboController`** — CRUD for receipts. `show()` handles both JSON response and PDF generation (supports `?reporte=pdf` and `?reporte=pdf-codigo` query params). The `recibo.show` route is excluded from Splade middleware to allow direct PDF streaming.
- **`PersonaController`** — CRUD for client persons.
- **`Admin\UserController`** / **`Admin\RoleController`** — user/role management under `/admin` prefix, gated by permissions.

### PDF Reports
Two report views exist:
- `resources/views/recibo/reporte.blade.php` — standard receipt PDF
- `resources/views/recibo/reporte-codigo.blade.php` — receipt PDF with QR code embedded as base64

Paper size: custom `[0, 0, 306.1, 396.85]` points (approx. half-letter landscape).

### Public Verification
`GET /verificar/{hash}` — public route (no auth required) that looks up a receipt by its MD5 hash and displays a verification page with confetti animation. This is the URL encoded in QR codes.

### Helpers (`app/Helpers/`)
- **`NumberToWords`** — converts numeric amounts to Spanish words for the `cantidad_literal` field (e.g., "CIENTO VEINTE con 00/100 Bs").
- **`FormatoFecha`** — date formatting utilities.
- **`FormatoTexto`** — text formatting (e.g., `zero_fill_left` for serial numbers).
- **`Helper.php`** — autoloaded global functions (e.g., `f_formato()`).

### Frontend
- Entry: `resources/js/app.js` and `resources/js/ssr.js`
- Views use Blade + Splade components (e.g., `<x-splade-table>`, `<x-splade-form>`, `<x-splade-toast>`)
- The verification page (`verificar.blade.php`) is a standalone HTML page (no Splade/Vite) using a custom CSS file at `public/css/moodly-style.css`

### Database
SQLite database at `database/database.sqlite`. Configure in `.env` with `DB_CONNECTION=sqlite`.

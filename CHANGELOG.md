# Changelog

## Phase 1: Rebranding from Flowpoint to Stockwise (2026-11-04)

Scope: rename and rebrand only. No routes, controllers, models, migrations, database
tables, business logic or dependencies were changed, and no design (Phase 2) changes were made.

This package contains **9 files**: 7 modified and 2 created. Paths are relative to the
project root.

### Modified files (7)

| # | File | Line(s) | Change |
|---|------|---------|--------|
| 1 | `config/app.php` | 16 | Default application name: `env('APP_NAME', 'Laravel')` to `env('APP_NAME', 'Stockwise')`. Used when `APP_NAME` is missing from `.env`. |
| 2 | `.env.example` | 1 | `APP_NAME=Laravel` to `APP_NAME=Stockwise`. `MAIL_FROM_NAME` and `VITE_APP_NAME` already copy this value, so they follow automatically. |
| 3 | `composer.json` | 5 | `description` changed to "Stockwise: an inventory and sales management system built with Laravel." The package `name` was deliberately **not** changed because it is part of the `composer.lock` fingerprint. |
| 4 | `resources/views/layouts/app.blade.php` | 6, 21, 76 | Tab title now `@hasSection('title')@yield('title') \| @endif{{ config('app.name', 'Stockwise') }}` (fallback was `Flowpoint`). Sidebar logo now `images/stockwise-logo-white.svg` with `alt="{{ config('app.name') }} logo"`. Footer now `(c) {{ date('Y') }} ZenFour {{ config('app.name') }}` (was `ZenFour Flowpoint`). |
| 5 | `resources/views/layouts/auth.blade.php` | 6, 20-21, 32 | Same three changes for the login/register layout. The fallback title `Defualt` (typo) is gone. |
| 6 | `resources/views/layouts/apptesting.blade.php` | 7, 22, 84 | Same three changes. This layout is not used by any page; it was updated so no old brand text remains. |
| 7 | `README.md` | whole file | Replaced the one-line `Flowpoint-Laravel-Project` heading with a Stockwise README: overview, features, setup instructions, and these Phase 1 notes. |

### Created files (2)

| # | File | Purpose |
|---|------|---------|
| 8 | `public/images/stockwise-logo-white.svg` | Placeholder Stockwise logo (white wordmark "ZenFour STOCKWISE"). Same 1145 x 60 canvas as the old logo, so sidebar and login layouts are unchanged. Letters are vector paths, so no font is needed. Glyph outlines derive from the Inter typeface (SIL Open Font License 1.1). Replace with the final logo later, keeping the file name. |
| 9 | `CHANGELOG.md` | This file. |

### Not changed on purpose

- Models, controllers, routes, migrations, seeders, database tables and business logic.
- `resources/views/about.blade.php` ("Zenfour Frameworks" is the team name, not the product name).
- `composer.json` `name`, and `package-lock.json` `name`.
- `public/images/zenfour-logo-white.svg`: no longer referenced, but left in place. It is safe to delete once you have checked the app.
- Your local `.env` (not part of this package; see "Manual steps").
- The Git remote. Nothing was committed or pushed.

### Manual steps (outside this package)

1. Set `APP_NAME=Stockwise` in your own local `.env`, then run `php artisan optimize:clear`.
2. Rename the project folder to `Stockwise` (close the editor and dev server first).
3. Leave any named database (for example `DB_DATABASE`) as it is.

### Behavior changes to be aware of

- **Tab titles:** every page now shows `Page name | Stockwise`; a page without a title section shows `Stockwise`.
- **One-time logout:** the session cookie name is built from `APP_NAME`, so it changes to `stockwise-session` and users log in again once.
- **Name source:** titles, footer and logo alt text come from `APP_NAME`. If your local `.env` still has an old value, that old value will be displayed.

### Verification performed

Done on a scratch copy of the project with these files applied (the scratch copy is not part of this package):

- All Blade templates compiled successfully with `php artisan view:cache`, and every compiled view passed `php -l`.
- `config/app.php` passed `php -l`, and `config('app.name')` returns `Stockwise` from `.env.example`.
- `stockwise-logo-white.svg`: well-formed XML, valid `<svg>` root and `viewBox`, valid path data, no scripts or external references, renders in Chromium without clipping.
- `composer validate` passes and `composer install --dry-run` reports nothing to update, so `composer.lock` still matches `composer.json`.
- Six temporary branding checks passed: titles, logo path, alt text and footer on `/login`, `/register`, `/dashboard`, `/products`, `/sales`, `/sales-report`, `/reports`, `/about`, `/contact` and `/`, with no `Flowpoint` text rendered. These checks are not included in the package.
- Real-browser run: register, dashboard, inventory and login pages showed the correct titles, footer and logo.
- Setup steps in the README (`composer install`, `.env` copy, `key:generate`, `migrate`, `db:seed`, `serve`) were run from a fresh state.
- Searching the package for the old name finds it only in `README.md` and this file, where it describes the change.

### Known pre-existing issue (not caused by this phase)

`tests/Feature/ExampleTest.php` expects `GET /` to return HTTP 200, but `/` requires login and
redirects (HTTP 302). It fails identically on the original, unmodified code. It was left alone
because it is outside the rebranding scope.

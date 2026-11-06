# Stockwise — Project Handoff

Last updated: 2026-11-06 (end of Phase 2). Read this first when you pick the project up again.

## 1. Project identity and stack

| | |
|---|---|
| Name | **Stockwise** (formerly Flowpoint), inventory and sales management, "ZenFour Stockwise" |
| Repo / branch | `Axophyse/Flowpoint-Laravel-Project`, branch `Finals` (Phase 1 commit `5a2e27e`) |
| Backend | Laravel 12, PHP 8.4, SQLite, Pest tests |
| Frontend | Blade, Bootstrap **5.3.3** (CDN), Font Awesome **6.4.0** (CDN), Chart.js **4.6.1** (CDN, pinned), plain CSS/JS in `public/` (no build step needed to view the UI) |
| Auth | Laravel UI style auth (`Auth\*Controller`); `/dashboard`, products and sales routes are behind `auth` |

## 2. Design system ("Modern Minimalist")

Defined as CSS variables at the top of `public/css/app.css` (`--sw-*`). Do not hard-code colours elsewhere.

| Token | Value | Use |
|---|---|---|
| `--sw-white` | `#FFFFFF` | cards, sidebar, topbar, inputs |
| `--sw-surface` | `#F5F7F5` | page background, table headers, read-only inputs |
| `--sw-brand` | `#166534` | primary buttons, active nav, links, charts |
| `--sw-text` | `#1F2937` | body text |
| `--sw-border` | `#E5E7EB` | card and table borders |

Decisions: system font stack (no Google Fonts); rounded cards with a subtle shadow; Font Awesome kept; Bootstrap Offcanvas for the mobile drawer; currency shown as `₱` (presentation only).

Chart colours and the peso axis formatter live in `public/js/chart-theme.js` (`window.StockwiseChart`).

## 3. Phase 1 (done earlier)

Rebrand Flowpoint → Stockwise: app name in `config/app.php` and `.env.example`, page titles, sidebar/auth logo (`public/images/stockwise-logo-white.svg`), footer, README, CHANGELOG. No routes, controllers, models, migrations or tables were renamed.

## 4. Phase 2 (this delivery): UI redesign only

- **Shared shell** (`resources/views/layouts/app.blade.php`): fixed 248px sidebar on desktop; below 992px it becomes a Bootstrap Offcanvas drawer opened from a hamburger in the topbar. Topbar with page title and user dropdown, scrolling content area, footer that sits below the content. Signed-out visitors on public pages (About, Contact, Reports, Data Table) get a slim guest header instead of the sidebar.
- **Styles**: all shared rules (shell, cards, KPI tiles, tables, buttons, badges, alerts, forms, detail layouts, pagination) now live **once** in `public/css/app.css`, which loads in `<head>`. `custom.css` (Home/About/Contact), `inventory.css`, `sales.css` now hold only rules for their own module, so there are no duplicate selectors and load order no longer matters. All 28 `#1e4f5b` colours are gone.
- **Pages redesigned**: Dashboard, Inventory (list, create, edit, show), Sales (list, create, edit, show, report), Reports, Data Table, About, Contact, Home, Login, Register, Password reset (request, reset, confirm) and Email verify.
- **Tables**: every table sits in a scroll wrapper (the Inventory table had none), so narrow screens scroll the table, not the page.
- **Charts**: all Chart.js charts use the shared theme. `public/js/custom.js` registers a single `DOMContentLoaded` handler (it had two, which caused `Canvas is already in use` on `/reports`) and charts are created through `StockwiseChart.create()`, which destroys an existing chart on the same canvas first. Sort parsing now strips `₱` as well as `$` and `,`.
- **Currency**: every displayed `$` amount in views and inline scripts now shows `₱`. No stored value or calculation was touched.
- **Cache busting**: `app.css`/`auth.css` use `?v=filemtime`; other assets use `?v=phase2`.

### Deliberate additions to know about
1. A **Contact** link was added to the sidebar (the page and route already existed but nothing linked to it). To remove it, delete that one `<a>` in `layouts/app.blade.php`.
2. The **guest header** on public pages is new (links only to existing routes).
3. The logo fill changed from `#228B22` to the brand `#166534`. To revert, change the single `fill` in `public/images/stockwise-logo-white.svg`.

## 5. Important files

| File | Role |
|---|---|
| `resources/views/layouts/app.blade.php` | Main layout (sidebar, drawer, topbar, guest header, footer) |
| `resources/views/layouts/auth.blade.php` + `public/css/auth.css` | Login / register / password screens |
| `public/css/app.css` | Design tokens and all shared components |
| `public/css/custom.css`, `inventory.css`, `sales.css` | Module-only rules |
| `public/js/custom.js` | Table sorting + Reports charts (single init handler) |
| `public/js/chart-theme.js` | **New.** Chart.js theme + safe chart factory |
| `resources/views/**` | All 23 views restyled |

Not used, left untouched: `resources/views/layouts/apptesting.blade.php` (links a missing `css/custom1.css`) and the stray `resources/layouts/app.blade.php`.

## 6. Must stay intact (hooks other code relies on)

`#logout-form` and the logout link's `onclick`; `data-bs-toggle` / `data-bs-dismiss` attributes; `.sortable` classes and `data-sort` attributes; table IDs `inventoryTable`, `salesTable`, `productsTable`; chart canvas IDs `dailySalesChart`, `categoryChart`, `priceRangeChart`, `monthlySalesChart`, `paymentMethodChart`; `@section('title')` / `@section('content')`; dynamic status classes (`status-in/low/out`, `status-completed/pending/cancelled/refunded`, `payment-card/cash/digital/transfer`, `quantity-high/medium/low`).

Protected and **unchanged** in Phase 2 (verified byte-for-byte against the baseline): `app/`, `routes/`, `database/`, `config/`, `bootstrap/`, `tests/`, `composer.*`, `package*.json`, `phpunit.xml`, `vite.config.js`, `artisan`.

## 7. Known issues and limitations (not fixed on purpose)

| # | Issue | Where |
|---|---|---|
| 1 | Sales "This Month" card equals Total Revenue (both use `$totalSales`) | `resources/views/sales/index.blade.php` lines 31 and 43 (calculation comes from the controller; left as instructed) |
| 2 | `/reports` and `/data-table` are reachable without logging in | `routes/web.php` lines 22-23 (outside the `auth` group). Needs a separate decision |
| 3 | Reports "Products by Price Range" chart still shows `$` ranges ("Under $50", "$50 - $200", "$201 - $500", "Over $500") | `app/Http/Controllers/ReportController.php` lines 26-29 (hard-coded in a SQL `CASE`; also these labels are the grouping keys). Needs owner approval to change |
| 4 | `tests/Feature/ExampleTest.php` fails (expects 200 on `/`, gets 302 redirect) | Failed identically on the untouched original |
| 5 | Contact success message typo "messag!" | `app/Http/Controllers/ContactController.php` line 23 |
| 6 | "Profile (no info)" in the user dropdown is a dead `#` link | Original behaviour, kept |
| 7 | `auth/verify.blade.php` is restyled but cannot be opened: it uses route `verification.resend`, and email verification is not enabled in `routes/web.php` | Pre-existing |
| 8 | Sale form "Total Amount" has no thousands separator (e.g. `₱2999.97`) | Original `toFixed(2)` script, kept |
| 9 | Bootstrap, Font Awesome and Chart.js come from CDNs; offline, the app loses styling/icons/charts | Original design |
| 10 | The Sales table has 10 columns: it fits without scrolling only at about 1440px and wider; below that it scrolls sideways inside its card (Inventory: below about 1340px). The page itself never scrolls sideways (measured at 1366, 1280, 1200, 1100, 992) | By design |

## 8. Testing performed (real Chromium via Playwright, scratch copy)

Environment: a scratch copy of the project served by `php artisan serve` with a seeded SQLite DB (13 products incl. 5 QA-only rows, 27 sales, 1 test user). The sandbox cannot reach CDNs, so the **same pinned versions** of Bootstrap 5.3.3, Font Awesome 6.4.0 and Chart.js 4.6.1 were served from local copies through request interception. Viewports: 1440×900, iPad (810×1080) and iPhone 13 (390×844) emulation.

- **Page sweep, 72 loads** (17 signed-in + 7 guest pages × 3 sizes): HTTP 200, no horizontal page scroll, no console/page errors, no failed local requests, no `$` amounts in rendered text, footer below content. Result: all clean.
- **88 interactive checks, 88 passed**: sidebar pinned and full-height; drawer opens with the hamburger and closes with ✕, Escape and backdrop; drawer links navigate; resizing past 992px while open; user dropdown fits the viewport; logout via `#logout-form` ends the session; guest shell on public pages; login error and register validation; sorting with `₱1,000.50`-style values (Inventory, Sales, Data Table) both directions; pagination page 2 for Inventory (3 rows) and Sales (12 rows); table scroll wrappers at 810/390; charts render with preserved IDs and **no `Canvas is already in use`** on Dashboard, Reports and Sales Report; charts fit at 390px; product create validation, create, edit, delete (in the scratch DB); sale form live total/summary in `₱` and stock validation; contact form success.
- Also run: reset-password-with-token, confirm-password and request-reset pages render at 1440 and 390; `php artisan view:cache` compiles every view; `php artisan test`: 7 passed, 1 failed (issue 4).

**Not tested / inspection only**: real devices, Safari and Firefox (Chromium only); loading assets from the real CDNs; email verify screen (no route, issue 7); actual email delivery for password reset; print layout; keyboard-only and screen-reader walkthroughs (focus styles and `aria` attributes were added but only checked in code).

## 9. Remaining work (suggestions, none are blockers)

- Decide on issues 1-3 above (they need business or access-control decisions, not UI work).
- Consider self-hosting Bootstrap/Font Awesome/Chart.js if the app must work offline.
- Add a cross-browser pass (Safari, Firefox) and a keyboard/screen-reader pass.

## 10. Apply it locally

1. Make sure your work is committed on `Finals`, then compare this ZIP with your tree: Phase 2 only touches `public/` and `resources/views/` plus `CHANGELOG.md` and this file. Note: this ZIP was assembled from the original upload plus the Phase 1 package, because the Git commit itself could not be inspected from a ZIP, so diff first.
2. Copy the ZIP contents over your project (keep your `.env`, `vendor/`, and `database/database.sqlite`).
3. `php artisan view:clear` then `php artisan serve`; hard-refresh the browser (Ctrl+F5).
4. Review `git diff`, then commit on your own branch.

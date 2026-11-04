# Stockwise

Stockwise is a web-based inventory and sales management system built with Laravel.
It helps a small business keep track of its products, record sales, and review a
dashboard and reports.

## Features

- User registration and login
- Inventory (product) management: add, view, edit and delete products
- Sales management: record, view, edit and delete sales
- Sales report, summary reports and a dashboard
- "Members" (About) and Contact pages

## Requirements

- PHP 8.2 or newer
- [Composer](https://getcomposer.org/)
- Node.js and npm (only needed if you use the `composer run setup` shortcut below)

The default database is SQLite, so you do not need to install a separate database server.

## Setup (first time)

Open a terminal **inside the project folder** (`Stockwise`) and follow either option.

### Option A: one command

```bash
composer run setup
```

This runs the project's `setup` script, which installs the PHP packages, creates your
`.env` file from `.env.example`, generates the application key, runs the database
migrations, then runs `npm install` and `npm run build`.

### Option B: step by step

```bash
composer install

# Create your own .env file (it is never committed to Git)
cp .env.example .env          # Windows Command Prompt: copy .env.example .env

php artisan key:generate
php artisan migrate           # creates database/database.sqlite for you (if Laravel asks
                              # "Would you like to create it?", answer yes)
php artisan db:seed           # optional: adds 8 sample products and 27 sample sales
```

### Start the application

```bash
php artisan serve
```

Then open <http://127.0.0.1:8000> in your browser.

The seeder does **not** create a user account. Click **Register** on the login page to
create your first account.

### Check that the app name is correct

Open your `.env` file and make sure this line says:

```
APP_NAME=Stockwise
```

The app name shown in browser tabs and page footers comes from this setting. If you change
`.env`, run `php artisan optimize:clear` so Laravel picks up the change.

## Phase 1: Rebranding from Flowpoint to Stockwise

This project was previously called **Flowpoint**. Phase 1 renames the application and
updates the branding. No functionality, routes, controllers, models, migrations or
database tables were changed. See `CHANGELOG.md` for the complete list of files.

What changed:

- **App name:** `config/app.php` and `.env.example` now default to `Stockwise`.
- **Single source of truth:** the layouts now read the name from `config('app.name')`, so a
  future rename only needs `APP_NAME` in `.env`.
- **Browser tab titles:** pages now show `Page name | Stockwise` (for example
  `Dashboard | Stockwise`). A page without its own title shows just `Stockwise`.
- **Logo:** a new `public/images/stockwise-logo-white.svg` replaces the old logo in the
  sidebar and on the login/register pages. It is a **placeholder wordmark**; replace the
  file with your final logo whenever you are ready (keep the same file name).
- **Footer:** now reads `(c) <year> ZenFour Stockwise`. "ZenFour" is kept as the team credit.
- **Documentation:** this README; `composer.json` description updated.
- **Typo fixed while editing the same line:** the login/register layout's fallback title
  was `Defualt`.

### Applying this package to your existing project

1. **Back up first.** Copy your project folder, or make sure `git status` is clean.
2. Close your editor and stop any running `php artisan serve`.
3. Unzip this package and copy its contents into your project folder, choosing **replace**
   when asked. The folder paths inside the ZIP match the project, so files land in the
   right place. If you changed any of the listed files after downloading the original
   project, merge those edits by hand instead of replacing.
4. Edit your own local `.env` (this package deliberately does not include it) and set
   `APP_NAME=Stockwise`.
5. Run `php artisan optimize:clear`.
6. Rename the project folder to `Stockwise` (see below), then start the app and check the
   login page, dashboard and Inventory page.

You can delete this "Applying this package" section from the README once you are done.

### Renaming the project folder

Do this on your computer, with the editor and any dev server closed:

- Rename `Flowpoint-Laravel-Project-main` (or whatever your folder is called) to `Stockwise`.
- If you use XAMPP or Laragon, the address of your site may change to match the new folder name.
- Do **not** change your Git remote as part of this phase. The GitHub repository keeps its
  current name until you decide to rename it.
- Reopen the folder in your editor, then run `php artisan optimize:clear`.

### Things to expect

- **You may be logged out once.** Laravel builds the session cookie name from `APP_NAME`
  (it becomes `stockwise-session`), so existing logins stop working. Just log in again.
- **The old logo file stays in place.** `public/images/zenfour-logo-white.svg` is no longer
  used. It is safe to delete after you have confirmed everything looks right.
- **Database name:** if your local `.env` uses a named database (for example `DB_DATABASE=flowpoint`),
  leave it as it is. Renaming a database is outside this phase.

## Credits

Built by the ZenFour team.

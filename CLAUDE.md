# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Tundra: an iGoogle-style personal dashboard ("rss reader"). Users have tabs, each tab has columns/sections, each section holds draggable widgets (RSS feeds, JSON feeds, etc.) with per-widget config and ordering. Built on **CodeIgniter 2.0.3** (PHP, MVC) with the **Tank Auth** library for registration/login/activation, plus a bundled **Zend Framework** (`system/Zend`) used only for `Zend_Feed_Reader`.

There is no build tooling, package manager, or test suite in this repo — it's classic PHP served directly (this instance runs under MAMP). Verifying a change means loading the relevant page/route in a browser and checking the PHP error log; there is no `composer.json`, `phpunit.xml`, or JS bundler to run.

## Running it

Served via MAMP (Apache/PHP/MySQL) with the document root pointing at this directory. `ENVIRONMENT` is set to `'development'` in `index.php` (full error reporting). DB credentials live in `application/config/database.php`; app-wide config (base URL, encryption key, etc.) in `application/config/config.php`.

## Architecture

### Request flow
`index.php` → CodeIgniter front controller (`system/`) → routes in `application/config/routes.php` (default controller is `dashboard`, and `dashboard/(:any)` is remapped to `dashboard/tab/$1`) → controller in `application/controllers/`.

### Auth gate
`application/core/TN_AuthenticatedController.php` is the base class every "inside the app" controller extends (`Dashboard`, `Settings`, `News`, `Helper`). Its constructor:
- Redirects to `welcome` if `tank_auth->is_logged_in()` is false — this is the only auth check; there's no per-action permission system.
- Always loads `tundra_model` as `$this->tundra` and pre-populates `$this->_data['user_id']`, `username`, and the user's `profile.theme` / `profile.search_engine`.

`Auth` and `Welcome` controllers extend plain `CI_Controller` instead (login/registration must be reachable while logged out). Tank Auth itself (`application/libraries/Tank_auth.php`, config in `application/config/tank_auth.php`, models in `application/models/tank_auth/`) handles login, registration, activation emails, forgotten passwords, and autologin cookies — don't reimplement any of that by hand in controllers.

### The "two model instances" pattern
`Tundra_model` (`application/models/tundra_model.php`) is the one model for all dashboard/widget/theme data. It's loaded twice under different aliases in practice:
- Auto-loaded as `$this->tundra` by `TN_AuthenticatedController` for every authenticated request.
- Re-loaded as `$this->model` inside individual controllers (`Dashboard`, `Settings`, `News`) that need it under that name too.

Both aliases point at the same model class. When editing a controller that extends `TN_AuthenticatedController`, prefer `$this->tundra` since it's already available from the parent constructor — only add the second `$this->load->model('Tundra_model', 'model')` alias if you're touching code that already relies on the `$this->model` name, matching what's there.

### Widgets
A tab has columns (`section` rows) containing `widget` rows, each pointing at a `widget_type`. `Tundra_model::get_widgets_in_tab()` joins `widget`, `widget_type`, `section`, `tab` to render a tab; `Helper::get_page_configuration()` (`application/controllers/helper.php`) returns that as JSON for the frontend to build the grid. Widget drag/reorder posts to `Helper::set_widget_order()`, which remaps client-supplied ordering back onto DB rows per column. Per-widget settings are free-form serialized PHP (`widget.config`, saved/loaded via `serialize()`/`unserialize()` in `Helper::widget_configuration()` — not JSON), and `refresh` is a separate column controlling client-side polling interval.

Widget content itself is fetched by two dumb server-side proxies (avoiding browser CORS/CSP issues), not by the widget system directly:
- `Helper::rss_proxy()` — takes `?url=&display=`, runs it through `Zend_Feed_Reader::import()` (from the bundled `system/Zend`), renders `helper/rss_proxy` view or `helper/rss_error` on exception.
- `Helper::json_proxy()` — takes `?url=`, does a raw `file_get_contents()` and renders it back. Both trust the `url` param as-is; if you touch these, be aware they currently have no allowlist/validation on the target URL (SSRF-shaped) — flag rather than silently "fixing" this in an unrelated change, per scope discipline.

### Templating
`application/libraries/Template.php` is a tiny custom two-step view helper: `$this->template->load($template, $view, $data)` renders `$view` first, stuffs the result into `contents`, then renders `$template` with that. Only `Settings::index()` currently uses it (`settings/_template` wrapping `settings/index`); most controllers just call `$this->load->view()` directly and are their own "whole page."

### Frontend assets
No bundler/npm — static files in `assets/scripts` (`tundra.core.js`, `tundra.support.js`, plus `mt.core.js`/`mt.more.js` third-party) and `assets/styles` (per-area CSS files, plus a `themes/` directory matching the DB-driven `theme` table used in Settings). The `resources` helper (`application/helpers/resources_helper.php`) generates `<link>`/`<script>`/`<img>` tags from `assets/` via `get_style()`, `get_script()`, `get_image()` — use these in views rather than hand-writing asset paths, to stay consistent with `base_url`.

### Autoloading
`application/config/autoload.php` autoloads the `database`, `session`, `tank_auth`, and `template` libraries and the `resources`, `form`, `futurama`, `url` helpers on every request — no controller needs to load these explicitly.

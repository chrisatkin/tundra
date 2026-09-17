<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Old application/config/routes.php had `default_controller = dashboard`,
// but Dashboard isn't ported yet (Phase 5) -- Welcome is the CI2 app's
// logged-out landing page and stands in for `/` until then.
$routes->get('/', 'Welcome::index');
$routes->get('welcome', 'Welcome::index');
$routes->get('welcome/register', 'Welcome::register');

// Shield's own login/register/logout/magic-link routes, kept under an
// `auth/` prefix to match the old Tank-Auth-backed URLs
// (application/controllers/auth.php) that other views already link to
// (e.g. anchor('auth/logout', ...) in dashboard/index.php).
// 'auth-actions' (2FA/activation flow) is excluded: app/Config/Auth.php's
// $actions are both null, so those routes would be dead weight, and their
// hardcoded 'auth/a/...' paths would otherwise double up under this group
// to 'auth/auth/a/...'.
$routes->group('auth', ['filter' => 'rates'], static function (RouteCollection $routes): void {
    service('auth')->routes($routes, ['except' => ['auth-actions']]);
});

// Logged-in-only account actions (application/controllers/auth.php's
// change_password()/change_email()/unregister() -- see app/Controllers/Account.php).
$routes->group('auth', ['filter' => 'session'], static function (RouteCollection $routes): void {
    $routes->match(['GET', 'POST'], 'change_password', 'Account::changePassword');
    $routes->match(['GET', 'POST'], 'change_email', 'Account::changeEmail');
    $routes->match(['GET', 'POST'], 'unregister', 'Account::unregister');
});

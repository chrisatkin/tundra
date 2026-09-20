<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Old application/config/routes.php had `default_controller = dashboard`,
// with Dashboard itself (via TN_AuthenticatedController) redirecting to
// `welcome` when logged out. `/` is kept pointed at Welcome::index
// directly instead -- logged-out visitors land on the marketing page
// without a redirect round-trip, and logged-in users reach the dashboard
// via the `login` redirect below rather than through `/`.
$routes->get('/', 'Welcome::index');
$routes->get('welcome', 'Welcome::index');
$routes->get('welcome/register', 'Welcome::register');

// Kubernetes liveness/readiness probes -- unauthenticated, kubelet can't log in.
$routes->get('healthz', 'Health::live');
$routes->get('healthz/ready', 'Health::ready');

// Dashboard (application/controllers/dashboard.php) + its widget AJAX
// backend (application/controllers/helper.php). `dashboard/(:any)` matches
// the old CI2 routes.php remap of the same shape.
$routes->group('', ['filter' => 'session'], static function (RouteCollection $routes): void {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/(:any)', 'Dashboard::tab/$1');

    $routes->get('helper/script/(:any)', 'Helper::script/$1');
    $routes->get('helper/get_page_configuration/(:any)', 'Helper::getPageConfiguration/$1');
    $routes->post('helper/set_widget_order', 'Helper::setWidgetOrder');
    $routes->get('helper/get_widget_html/(:any)', 'Helper::getWidgetHtml/$1');
    $routes->match(['GET', 'POST'], 'helper/widget_configuration', 'Helper::widgetConfiguration');
    $routes->get('helper/widget_configuration/(:num)', 'Helper::widgetConfiguration/$1');
    $routes->get('helper/rss_proxy', 'Helper::rssProxy');
    $routes->get('helper/json_proxy', 'Helper::jsonProxy');

    // Settings (application/controllers/settings.php) and News
    // (application/controllers/news.php).
    $routes->match(['GET', 'POST'], 'settings', 'Settings::index');
    $routes->get('news', 'News::index');
});

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

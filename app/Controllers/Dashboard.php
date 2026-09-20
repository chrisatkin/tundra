<?php

namespace App\Controllers;

use App\Models\TundraModel;

/**
 * Ported from application/controllers/dashboard.php. The old
 * TN_AuthenticatedController base class's job (require login, preload
 * tundra_model + user_id/username/profile) is done here directly, matching
 * how Account.php already handles "logged-in only" controllers in this
 * app -- via the `session` route filter (app/Config/Routes.php) plus a
 * direct auth()->user() call, rather than a shared base controller.
 */
class Dashboard extends BaseController
{
    private TundraModel $tundra;

    public function __construct()
    {
        $this->tundra = model(TundraModel::class);
    }

    public function index()
    {
        return redirect()->to('dashboard/home');
    }

    public function tab(string $tab)
    {
        $user = auth()->user();

        $data = [
            'tab'      => $tab,
            'tabs'     => $this->tundra->getTabsForUser($user->id),
            'username' => $user->username,
            'profile'  => [
                'theme'         => $this->tundra->getTheme($user->id),
                'search_engine' => $this->tundra->getSearchEngine($user->id),
            ],
        ];

        return view('dashboard/index', $data);
    }
}

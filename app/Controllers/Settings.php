<?php

namespace App\Controllers;

use App\Models\TundraModel;

/**
 * Ported from application/controllers/settings.php. See Dashboard.php for
 * why there's no shared "authenticated controller" base class in this port.
 */
class Settings extends BaseController
{
    private TundraModel $tundra;

    public function __construct()
    {
        $this->tundra = model(TundraModel::class);
    }

    public function index()
    {
        $user = auth()->user();

        if ($this->request->getMethod() === 'post') {
            $this->tundra->saveNewTheme($user->id, (int) $this->request->getPost('theme'));

            return redirect()->to('settings');
        }

        $data = [
            'themes'   => $this->tundra->getAllThemes(),
            'tabs'     => $this->tundra->getTabsForUser($user->id),
            'username' => $user->username,
            'profile'  => [
                'theme'         => $this->tundra->getTheme($user->id),
                'search_engine' => $this->tundra->getSearchEngine($user->id),
            ],
        ];

        return view('settings/index', $data);
    }
}

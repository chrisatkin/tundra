<?php

namespace App\Controllers;

use App\Models\TundraModel;

/**
 * Ported from application/controllers/news.php. See Dashboard.php for why
 * there's no shared "authenticated controller" base class in this port.
 */
class News extends BaseController
{
    private TundraModel $tundra;

    public function __construct()
    {
        $this->tundra = model(TundraModel::class);
    }

    public function index()
    {
        $user = auth()->user();

        $data = [
            'tabs'     => $this->tundra->getTabsForUser($user->id),
            'username' => $user->username,
            'profile'  => [
                'theme'         => $this->tundra->getTheme($user->id),
                'search_engine' => $this->tundra->getSearchEngine($user->id),
            ],
        ];

        return view('news/latest', $data);
    }
}

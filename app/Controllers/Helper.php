<?php

namespace App\Controllers;

use App\Models\TundraModel;
use SimplePie\SimplePie;

/**
 * Ported from application/controllers/helper.php -- the widget AJAX
 * backend the dashboard's JS (app/Views/helper/script/*.php, ported from
 * assets/scripts/tundra.core*.js) talks to. See Dashboard.php for why
 * there's no shared "authenticated controller" base class in this port.
 */
class Helper extends BaseController
{
    private TundraModel $tundra;

    public function __construct()
    {
        $this->tundra = model(TundraModel::class);
    }

    public function script(string $which)
    {
        // 'debug' => false: skip the dev-mode debug toolbar's per-view
        // <!-- DEBUG-VIEW --> comment wrapping. Those are invisible in an
        // HTML response but this is served as text/javascript (a
        // non-"html" content type), so they'd land in the file verbatim
        // and break the browser's JS parse.
        return $this->response
            ->setContentType('text/javascript')
            ->setBody(view('helper/script/' . $which, [], ['debug' => false]));
    }

    public function getPageConfiguration(string $tabName)
    {
        $data = [
            'tab_name' => $tabName,
            'config'   => $this->tundra->getWidgetsInTab(ucfirst($tabName), auth()->user()->id),
        ];

        // Same DEBUG-VIEW concern as script() above -- this is JSON,
        // consumed by Request.JSON() in app/Views/helper/script/init.php.
        return $this->response
            ->setContentType('application/json')
            ->setBody(view('helper/page_configuration', $data, ['debug' => false]));
    }

    public function setWidgetOrder()
    {
        $tab      = $this->request->getPost('tab');
        $newOrder = $this->request->getPost('order');

        // $tab is the lowercase URL segment (see _current_tab in
        // app/Views/dashboard/index.php), but tab.name is stored
        // capitalized ("Home"), same as getPageConfiguration() below --
        // ucfirst() here to match. Without it, getUniqueColumnsInTab()
        // returns no columns and array_combine() throws on the length
        // mismatch (that was the original CI2 app's behavior too, just
        // silent there instead of a 500).
        $currentColumns = $this->tundra->getUniqueColumnsInTab(ucfirst($tab), auth()->user()->id);
        $ordering        = array_combine($currentColumns, $newOrder ?? []);

        foreach ($ordering as $newColumn => $value) {
            foreach ($value as $order => $widget) {
                $id = explode('-', $widget);
                $id = (int) $id[1];

                $this->tundra->saveWidgetOrder($id, $order + 1, $newColumn);
            }
        }
    }

    public function getWidgetHtml(string $widget)
    {
        return view('helper/widget/' . $widget);
    }

    public function widgetConfiguration(?int $id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $id = (int) $this->request->getPost('widget');

            $newConfig = $this->request->getPost();
            foreach (['widget', 'submit', 'refresh'] as $toRemove) {
                unset($newConfig[$toRemove]);
            }

            $this->tundra->saveWidgetConfiguration($id, serialize($newConfig), (int) $this->request->getPost('refresh'));
        }

        $data = [
            'widget_info' => $this->tundra->getWidgetTypeData($id),
            'config'      => $this->tundra->getWidgetConfiguration($id),
        ];

        return view('helper/widget_configuration', $data);
    }

    public function rssProxy()
    {
        $url     = $this->request->getGet('url');
        $display = $this->request->getGet('display');

        if (! $url || ! $display) {
            return;
        }

        helper('text');

        $feed = new SimplePie();
        $feed->set_feed_url($url);
        // No cache dir to manage -- matches the old Zend_Feed_Reader::import()
        // call, which also fetched fresh on every request.
        $feed->enable_cache(false);

        if (! $feed->init()) {
            return view('helper/rss_error');
        }

        return view('helper/rss_proxy', ['feed' => $feed]);
    }

    public function jsonProxy()
    {
        return $this->response
            ->setContentType('application/json')
            ->setBody(view('helper/json_proxy', ['content' => file_get_contents($this->request->getGet('url'))], ['debug' => false]));
    }
}

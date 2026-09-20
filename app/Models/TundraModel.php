<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Ported from application/models/tundra_model.php, same queries against the
 * same schema (see app/Database/Migrations) -- method names are camelCase
 * to match this app's CI4 controllers, unlike the old snake_case CI2 model.
 */
class TundraModel extends Model
{
    public function getTabsForUser(int $user): array
    {
        return $this->db->table('tab')->where('user', $user)->get()->getResultArray();
    }

    public function getWidgetsInTab(string $tab, int $user): array
    {
        return $this->db->query('
            SELECT widget.id, widget.title, widget.type, widget.config, widget.column, widget_type.name AS type, widget.refresh, widget.order
            FROM widget, widget_type, section, tab
            WHERE tab.name = ' . $this->db->escape($tab) . '
            AND tab.user = ' . $this->db->escape($user) . '
            AND section.tab = tab.id
            AND widget.column = section.id
            AND widget.type = widget_type.id
            ORDER BY widget.column, widget.order
        ')->getResultArray();
    }

    public function getSearchEngine(int $user): array
    {
        $rows = $this->db->query('
            SELECT search_engine.name, search_engine.action, search_engine.modifier
            FROM user_profile, search_engine
            WHERE user_profile.search_engine = search_engine.id
            AND user_profile.user_id = ' . $this->db->escape($user)
        )->getResultArray();

        return $rows[0];
    }

    public function getTheme(int $user): array
    {
        $rows = $this->db->query('
            SELECT theme.name, theme.directory, user.username
            FROM user_profile, theme, users AS user
            WHERE user_profile.theme = theme.id
            AND theme.creator = user.id
            AND user_profile.user_id = ' . $this->db->escape($user)
        )->getResultArray();

        return $rows[0];
    }

    public function getAllThemes(): array
    {
        return $this->db->query('
            SELECT theme.id, theme.name, theme.description, theme.directory, user.username AS creator
            FROM theme, users AS user
            WHERE theme.creator = user.id
            ORDER BY theme.id
        ')->getResultArray();
    }

    public function getWidgetConfiguration(int $id): array
    {
        $rows = $this->db->query('
            SELECT *
            FROM widget
            WHERE widget.id = ' . $this->db->escape($id)
        )->getResultArray();

        return $rows[0];
    }

    public function getWidgetTypeData(int $id): array
    {
        $rows = $this->db->query('
            SELECT widget_type.*
            FROM widget, widget_type
            WHERE widget.id = ' . $this->db->escape($id) . '
            AND widget.type = widget_type.id
        ')->getResultArray();

        return $rows[0];
    }

    public function saveNewTheme(int $user, int $newTheme): void
    {
        $this->db->table('user_profile')->where('user_id', $user)->update(['theme' => $newTheme]);
    }

    public function saveWidgetConfiguration(int $id, string $newConfig, int $refresh): void
    {
        $this->db->table('widget')->where('id', $id)->update(['config' => $newConfig, 'refresh' => $refresh]);
    }

    public function saveWidgetOrder(int $widgetId, int $newOrder, int $newColumn): void
    {
        $this->db->table('widget')->where('id', $widgetId)->update(['order' => $newOrder, 'column' => $newColumn]);
    }

    public function getUniqueColumnsInTab(string $tab, int $user): array
    {
        $rows = $this->db->query('
            SELECT DISTINCT widget.column
            FROM widget, section, tab
            WHERE widget.column = section.id
            AND section.tab = tab.id
            AND tab.user = ' . $this->db->escape($user) . '
            AND tab.name = ' . $this->db->escape($tab)
        )->getResultArray();

        $result = [];
        foreach ($rows as $item) {
            $result[] = (int) $item['column'];
        }

        return $result;
    }
}

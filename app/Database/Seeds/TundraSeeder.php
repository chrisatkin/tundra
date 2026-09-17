<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Ports the app-specific rows from the old CI2 app's
 * application/config/seed.sql + seed_home_tab.sql onto the CI4 schema.
 * Run only after a real user exists via Shield (php spark shield:user create),
 * never hand-inserted into `users` directly.
 */
class TundraSeeder extends Seeder
{
    public function run()
    {
        $user = $this->db->table('users')->where('username', 'chrisatkin')->get()->getRow();

        if ($user === null) {
            throw new \RuntimeException('Create the chrisatkin user via `php spark shield:user create` before running this seeder.');
        }

        $userId = $user->id;

        $this->db->table('theme')->insert([
            'name' => 'City', 'description' => 'City theme', 'directory' => 'city', 'creator' => $userId,
        ]);
        $cityThemeId = $this->db->insertID();

        $this->db->table('theme')->insert([
            'name' => 'City Lights', 'description' => 'City Lights theme', 'directory' => 'citylights', 'creator' => $userId,
        ]);
        $this->db->table('theme')->insert([
            'name' => 'Nebula', 'description' => 'Nebula theme', 'directory' => 'nebula', 'creator' => $userId,
        ]);

        $this->db->table('search_engine')->insert([
            'name' => 'Google', 'action' => 'http://www.google.com/search', 'modifier' => 'q',
        ]);
        $googleId = $this->db->insertID();

        $this->db->table('user_profile')->insert([
            'user_id' => $userId, 'theme' => $cityThemeId, 'search_engine' => $googleId,
        ]);

        $this->db->table('tab')->insert(['user' => $userId, 'name' => 'Home']);
        $homeTabId = $this->db->insertID();

        // Explicit ids 1, 2, 3 (left/center/right): app/Views/helper/page_configuration.php
        // (once ported) assumes a tab's widget.column values run 1..N contiguously within
        // that tab -- true as long as a tab's sections are the first ones inserted, as here.
        // Same pre-existing quirk noted in the old seed.sql/seed_home_tab.sql.
        $this->db->table('section')->insert(['id' => 1, 'tab' => $homeTabId]);
        $this->db->table('section')->insert(['id' => 2, 'tab' => $homeTabId]);
        $this->db->table('section')->insert(['id' => 3, 'tab' => $homeTabId]);

        $this->db->table('widget_type')->insert([
            'name'          => 'TundraRssWidget',
            'configuration' => 'a:2:{i:0;a:2:{s:4:"name";s:4:"feed";s:11:"description";s:8:"Feed URL";}i:1;a:2:{s:4:"name";s:7:"display";s:11:"description";s:26:"Number of items to display";}}',
        ]);
        $rssTypeId = $this->db->insertID();

        $this->db->table('widget_type')->insert([
            'name' => 'TundraBbcFeed', 'configuration' => 'a:0:{}',
        ]);
        $bbcTypeId = $this->db->insertID();

        // Left column: MacRumors front page, then MacRumors Mac Blog.
        $this->db->table('widget')->insert([
            'title' => 'MacRumors', 'type' => $rssTypeId,
            'config' => 'a:2:{s:4:"feed";s:41:"https://feeds.macrumors.com/MacRumors-All";s:7:"display";i:10;}',
            'column' => 1, 'refresh' => 30, 'order' => 1,
        ]);
        $this->db->table('widget')->insert([
            'title' => 'MacRumors: Mac Blog', 'type' => $rssTypeId,
            'config' => 'a:2:{s:4:"feed";s:41:"https://feeds.macrumors.com/MacRumors-Mac";s:7:"display";i:10;}',
            'column' => 1, 'refresh' => 30, 'order' => 2,
        ]);

        // Center column: The Guardian, World news.
        $this->db->table('widget')->insert([
            'title' => 'The Guardian: World News', 'type' => $rssTypeId,
            'config' => 'a:2:{s:4:"feed";s:37:"https://www.theguardian.com/world/rss";s:7:"display";i:10;}',
            'column' => 2, 'refresh' => 30, 'order' => 1,
        ]);

        // Right column: BBC News, UK Edition (title/feed hardcoded client-side).
        $this->db->table('widget')->insert([
            'title' => 'BBC News', 'type' => $bbcTypeId, 'config' => 'a:0:{}',
            'column' => 3, 'refresh' => 0, 'order' => 1,
        ]);
    }
}

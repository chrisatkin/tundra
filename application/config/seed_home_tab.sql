-- Configure the "Home" tab with 3 columns:
--   left:   MacRumors front page, MacRumors Mac Blog
--   center: The Guardian - World news
--   right:  BBC News - UK Edition
--
-- Run application/config/seed.sql first -- this assumes the `chrisatkin`
-- user and the "Home" tab it creates already exist.
--
-- Feed URLs (checked live before writing this):
--   https://feeds.macrumors.com/MacRumors-All  -- "MacRumors: Mac News and Rumors - All Stories" (front page)
--   https://feeds.macrumors.com/MacRumors-Mac  -- "MacRumors: Mac News and Rumors - Mac Blog"
--   https://www.theguardian.com/world/rss      -- Guardian's standard per-section feed pattern (couldn't
--                                                  fetch it directly to double-check, but this URL scheme
--                                                  is long-documented and unchanged)
--   BBC News UK Edition isn't configurable -- it's Tundra's dedicated `TundraBbcFeed` widget type, whose
--   feed URL/title are hardcoded client-side in assets/views/helper/script/widget.php, ignoring `widget.config`
--   entirely. So the BBC widget below carries no feed config; that's expected, not an oversight.
--
-- Safe to re-run: it wipes any existing columns/widgets on the Home tab first.

SET NAMES utf8;

-- --------------------------------------------------------------------------
-- Clear out whatever the Home tab currently has
-- --------------------------------------------------------------------------

DELETE w FROM widget w
  JOIN section s ON w.column = s.id
  JOIN tab t ON s.tab = t.id
  JOIN user u ON t.user = u.id
  WHERE u.username = 'chrisatkin' AND t.name = 'Home';

DELETE s FROM section s
  JOIN tab t ON s.tab = t.id
  JOIN user u ON t.user = u.id
  WHERE u.username = 'chrisatkin' AND t.name = 'Home';

DELETE FROM widget_type WHERE name IN ('TundraRssWidget', 'TundraBbcFeed');

-- --------------------------------------------------------------------------
-- Columns
-- --------------------------------------------------------------------------

-- Explicit ids 1, 2, 3 (left, center, right) rather than letting AUTO_INCREMENT
-- pick them: application/views/helper/page_configuration.php assumes a tab's
-- widget.column values run 1..N contiguously *within that tab* -- it doesn't
-- re-normalize section.id per tab, so this only holds if a tab's sections are
-- the first ones inserted after it, as they are here. See the same note in
-- seed.sql. This is a pre-existing quirk in the app, not something this
-- script tries to fix.
INSERT INTO `section` (`id`, `tab`) VALUES
  (1, (SELECT t.id FROM tab t JOIN user u ON t.user = u.id WHERE u.username = 'chrisatkin' AND t.name = 'Home')),
  (2, (SELECT t.id FROM tab t JOIN user u ON t.user = u.id WHERE u.username = 'chrisatkin' AND t.name = 'Home')),
  (3, (SELECT t.id FROM tab t JOIN user u ON t.user = u.id WHERE u.username = 'chrisatkin' AND t.name = 'Home'));

-- --------------------------------------------------------------------------
-- Widget types
-- --------------------------------------------------------------------------

-- Generic RSS widget (assets/views/helper/script/widget.php: TundraRssWidget).
-- `configuration` drives the two editable fields shown in the widget's settings
-- form (application/views/helper/widget_configuration.php); the actual per-widget
-- values live in widget.config below, keyed to match ('feed', 'display').
INSERT INTO `widget_type` (`name`, `configuration`) VALUES
  ('TundraRssWidget', 'a:2:{i:0;a:2:{s:4:"name";s:4:"feed";s:11:"description";s:8:"Feed URL";}i:1;a:2:{s:4:"name";s:7:"display";s:11:"description";s:26:"Number of items to display";}}');

-- Dedicated BBC widget type -- no configurable fields (see note above).
INSERT INTO `widget_type` (`name`, `configuration`) VALUES
  ('TundraBbcFeed', 'a:0:{}');

-- --------------------------------------------------------------------------
-- Widgets
-- --------------------------------------------------------------------------

-- Left column (section 1): MacRumors front page, then MacRumors Mac Blog.
INSERT INTO `widget` (`title`, `type`, `config`, `column`, `refresh`, `order`) VALUES
  ('MacRumors', (SELECT id FROM widget_type WHERE name = 'TundraRssWidget'),
   'a:2:{s:4:"feed";s:41:"https://feeds.macrumors.com/MacRumors-All";s:7:"display";i:10;}', 1, 30, 1),
  ('MacRumors: Mac Blog', (SELECT id FROM widget_type WHERE name = 'TundraRssWidget'),
   'a:2:{s:4:"feed";s:41:"https://feeds.macrumors.com/MacRumors-Mac";s:7:"display";i:10;}', 1, 30, 2);

-- Center column (section 2): The Guardian, World news.
INSERT INTO `widget` (`title`, `type`, `config`, `column`, `refresh`, `order`) VALUES
  ('The Guardian: World News', (SELECT id FROM widget_type WHERE name = 'TundraRssWidget'),
   'a:2:{s:4:"feed";s:37:"https://www.theguardian.com/world/rss";s:7:"display";i:10;}', 2, 30, 1);

-- Right column (section 3): BBC News, UK Edition (title/feed hardcoded client-side).
INSERT INTO `widget` (`title`, `type`, `config`, `column`, `refresh`, `order`) VALUES
  ('BBC News', (SELECT id FROM widget_type WHERE name = 'TundraBbcFeed'), 'a:0:{}', 3, 0, 1);

-- Tundra database seed
--
-- The original schema/seed for this app was lost. Every table below is
-- reconstructed from what the PHP code actually reads/writes (Tank_auth's
-- models in application/models/tank_auth/, Tundra_model, and CodeIgniter
-- 2.0.3's native Session library config in application/config/config.php).
-- Column widths/types are reasonable guesses, not a recovery of the
-- original DDL -- there was no migration/DDL file to recover them from.
--
-- Charset/collation matches application/config/database.php (utf8 / utf8_general_ci).
-- No FOREIGN KEY constraints are declared: the original app enforces these
-- relations in PHP only (no ON DELETE CASCADE etc. appears in the code),
-- so adding real constraints now would be a schema change beyond "restore
-- what was there."

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------------------------
-- Tank Auth tables
-- --------------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(80) NOT NULL,
  `new_email` VARCHAR(80) DEFAULT NULL,
  `new_email_key` VARCHAR(32) DEFAULT NULL,
  `new_password_key` VARCHAR(32) DEFAULT NULL,
  `new_password_requested` DATETIME DEFAULT NULL,
  `activated` TINYINT(1) NOT NULL DEFAULT 0,
  `banned` TINYINT(1) NOT NULL DEFAULT 0,
  `ban_reason` VARCHAR(255) DEFAULT NULL,
  `created` DATETIME NOT NULL,
  `last_ip` VARCHAR(45) DEFAULT NULL,
  `last_login` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` VARCHAR(45) NOT NULL,
  `login` VARCHAR(80) NOT NULL,
  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

DROP TABLE IF EXISTS `user_autologin`;
CREATE TABLE `user_autologin` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `key_id` VARCHAR(32) NOT NULL,
  `user_agent` VARCHAR(150) DEFAULT NULL,
  `last_ip` VARCHAR(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- CodeIgniter 2.0.3 native Session library table.
-- Name/columns come from application/config/config.php ($config['sess_table_name'] = 'session')
-- and the standard CI2 session schema (system/libraries/Session.php).
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0',
  `ip_address` VARCHAR(45) NOT NULL DEFAULT '0',
  `user_agent` VARCHAR(120) NOT NULL,
  `last_activity` INT UNSIGNED NOT NULL DEFAULT 0,
  `user_data` TEXT NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------------------------
-- Tundra application tables
-- --------------------------------------------------------------------------

-- Referenced by Tundra_model::get_theme() / get_all_themes() / save_new_theme().
-- `directory` values must match the folder names under assets/styles/themes/.
DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `directory` VARCHAR(50) NOT NULL,
  `creator` INT UNSIGNED NOT NULL COMMENT 'FK -> user.id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Referenced by Tundra_model::get_search_engine() and the dashboard header search box
-- (application/views/dashboard/index.php uses action/modifier/name directly).
DROP TABLE IF EXISTS `search_engine`;
CREATE TABLE `search_engine` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `action` VARCHAR(255) NOT NULL COMMENT 'form action URL',
  `modifier` VARCHAR(20) NOT NULL COMMENT 'query string param name, e.g. q',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- One row per user per theme/search-engine choice (Tundra_model / TN_AuthenticatedController).
DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE `user_profile` (
  `user_id` INT UNSIGNED NOT NULL COMMENT 'FK -> user.id',
  `theme` INT UNSIGNED DEFAULT NULL COMMENT 'FK -> theme.id',
  `search_engine` INT UNSIGNED DEFAULT NULL COMMENT 'FK -> search_engine.id',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- A dashboard tab, owned by a user (Dashboard::tab(), routes.php: dashboard/(:any) -> dashboard/tab/$1).
DROP TABLE IF EXISTS `tab`;
CREATE TABLE `tab` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` INT UNSIGNED NOT NULL COMMENT 'FK -> user.id',
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- A column within a tab. widget.column joins straight to section.id
-- (Tundra_model::get_widgets_in_tab), and application/views/helper/page_configuration.php
-- assumes column numbers run 1..N contiguously within a tab -- true as long as a
-- tab's sections are the first/only rows inserted, as they are here.
DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tab` INT UNSIGNED NOT NULL COMMENT 'FK -> tab.id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- `name` must exactly match one of the case labels in the client-side
-- TundraWidgetFactory switch (assets/views/helper/script/widget.php):
-- TundraRssWidget, TundraIframeWidget, TundraRedditBrowser, TundraBbcFeed, TundraWelcomeWidget.
-- `configuration` is a serialized PHP array of {name, description} field
-- definitions rendered by application/views/helper/widget_configuration.php.
DROP TABLE IF EXISTS `widget_type`;
CREATE TABLE `widget_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `configuration` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- `column` and `order` are unquoted reserved-ish words but this matches the
-- app's own raw SQL in Tundra_model.php (widget.column, widget.order),
-- which MySQL accepts when the identifier is table-qualified.
DROP TABLE IF EXISTS `widget`;
CREATE TABLE `widget` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `type` INT UNSIGNED NOT NULL COMMENT 'FK -> widget_type.id',
  `config` TEXT COMMENT 'serialized PHP array',
  `column` INT UNSIGNED NOT NULL COMMENT 'FK -> section.id',
  `refresh` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'minutes; 0 = never',
  `order` INT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------------------------
-- Seed data
-- --------------------------------------------------------------------------

-- chrisatkin / empires
-- Hash generated with this repo's own application/libraries/phpass-0.1/PasswordHash.php,
-- using the strength/portability settings from application/config/tank_auth.php
-- (phpass_hash_strength = 8, phpass_hash_portable = TRUE), and verified with
-- PasswordHash::CheckPassword() before being pasted in here.
INSERT INTO `user`
  (`id`, `username`, `password`, `email`, `activated`, `banned`, `created`)
VALUES
  (1, 'chrisatkin', '$P$B8kXpPi7hS78Tvot6tb3U9TPjpfAts.', 'ceag19@icloud.com', 1, 0, NOW());

-- One row per theme directory that actually exists under assets/styles/themes/.
INSERT INTO `theme` (`id`, `name`, `description`, `directory`, `creator`) VALUES
  (1, 'City', 'City theme', 'city', 1),
  (2, 'City Lights', 'City Lights theme', 'citylights', 1),
  (3, 'Nebula', 'Nebula theme', 'nebula', 1);

INSERT INTO `search_engine` (`id`, `name`, `action`, `modifier`) VALUES
  (1, 'Google', 'http://www.google.com/search', 'q');

INSERT INTO `user_profile` (`user_id`, `theme`, `search_engine`) VALUES
  (1, 1, 1);

INSERT INTO `tab` (`id`, `user`, `name`) VALUES
  (1, 1, 'Home');

INSERT INTO `section` (`id`, `tab`) VALUES
  (1, 1);

-- serialize(array()) === 'a:0:{}' -- welcome widget takes no configurable fields.
INSERT INTO `widget_type` (`id`, `name`, `configuration`) VALUES
  (1, 'TundraWelcomeWidget', 'a:0:{}');

INSERT INTO `widget` (`id`, `title`, `type`, `config`, `column`, `refresh`, `order`) VALUES
  (1, 'Welcome', 1, 'a:0:{}', 1, 0, 1);

-- login_attempts / user_autologin / session intentionally left empty; they're
-- populated at runtime as you log in.

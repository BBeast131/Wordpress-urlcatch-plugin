<?php
/**
 * Plugin Name: Above The Fold Tracker
 * Description: Tracks hyperlinks visible above the fold on the homepage and displays them for the past 7 days.
 * Version: 1.0.0
 * Author: Ethan
 * Requires at least: 6.0
 * Requires PHP: 7.3
 * License: GPL-2.0+
 */

defined('ABSPATH') or die('No script kiddies please!');

require_once __DIR__ . '/includes/tracker.php';
require_once __DIR__ . '/includes/database_manager.php';
require_once __DIR__ . '/includes/admin_page.php';

use AboveTheFoldTracker\AboveTheFoldTracker;
use AboveTheFoldTracker\DatabaseManager;
use AboveTheFoldTracker\AdminPage;

if (class_exists('AboveTheFoldTracker\AboveTheFoldTracker')) {
    $plugin = new AboveTheFoldTracker(new DatabaseManager(), new AdminPage());
    $plugin->init();
}
?>